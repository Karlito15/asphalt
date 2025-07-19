<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Able\Service\Cache\CacheAble;
use App\Interface\ServiceCacheInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * On retourne les données pour le tableau des stats du dashboard
 *
 */
class MissionAppService implements ServiceCacheInterface
{
    use CacheAble;

    private string $namespace = 'missions';

    public function __construct(
        private readonly ContainerInterface      $container,
    )
    {
    }

    public function cacheCreate(): array
    {
        // Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        // Cache
        $cache  = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $values = $cache->getItem($this->namespace);
        } catch (InvalidArgumentException $e) {
            $e->getMessage();
        }

        if ($values->isHit()) {
            return $values->get();
        } else {
            $results = [];

            $cache->get($this->namespace, function (ItemInterface $item) use ($results) {
                $item->expiresAt(new \DateTime('+7 days'));
                $item->set($results);

                return $results;
            });
            $cache->save($cache->getItem($this->namespace));

            return $results;
        }
    }

    public function cacheDelete(): void
    {
        // Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        // Cache : delete items for Dashboard
        $cache = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $cache->deleteItems([$this->namespace]);
        } catch (InvalidArgumentException $e) {
            $e->getMessage();
        }
    }
}
