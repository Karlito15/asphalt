<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Interface\CacheServiceInterface;
use App\Repository\InventoryAppRepository;
use App\Trait\Service\Cache\CacheTrait;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DashboardService implements CacheServiceInterface
{
    use CacheTrait;

    private string $namespace = 'dashboards';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly InventoryAppRepository  $inventories,
    )
    {
    }

    /**
     * Créé tous les fichiers caches liés au dashboard
     *
     * @return array
     */
    public function cacheCreate(): array
    {
        // Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        // Cache
        $cache  = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $values = $cache->getItem($this->namespace);

            if ($values->isHit()) {
                return $values->get();
            }

            $results = [
                'moneys'    => $this->inventories->findInventoriesByCategory('money'),
                'commons'   => $this->inventories->findInventoriesByCategory('common'),
                'rares'     => $this->inventories->findInventoriesByCategory('rare'),
                'jokers'    => $this->inventories->findInventoriesByCategory('joker'),
            ];

            $cache->get($this->namespace, function (ItemInterface $item) use ($results) {
                $item->expiresAt(new \DateTime('+7 days'));
                $item->set($results);

                return $results;
            });
            $cache->save($cache->getItem($this->namespace));

            return $results;
        } catch (InvalidArgumentException $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * Supprime tous les fichiers caches liés au dashboard
     *
     * @return void
     */
    public function cacheDelete(): void
    {
        // Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        // Cache : delete items for Dashboard
        $cache = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $cache->deleteItems([$this->namespace]);
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }
    }
}
