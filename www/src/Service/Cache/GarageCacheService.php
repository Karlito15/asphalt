<?php

namespace App\Service\Cache;

use App\Interface\AsphaltCacheInterface;
use App\Repository\AppGarageRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class GarageCacheService implements AsphaltCacheInterface
{
    private string $namespace = 'garages';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly AppGarageRepository     $garage,
    ) {}

    /**
     * Créé tous les fichiers caches liés au garage
     *
     * @throws InvalidArgumentException
     */
    public function createDataCache(string $cacheName): array
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache */
        $cache = new FilesystemAdapter($this->namespace, $lifetime['garage'], 'cache');
        $values = $cache->getItem($cacheName);
        if ($values->isHit()) {
            return $values->get();
        } else {
            $results   = [
                'index'     => $this->garage->getGarage()
            ];

            $cache->get($cacheName, function (ItemInterface $item) use ($results) {
                $item->expiresAt(new \DateTime('+7 days'));
                $item->set($results);

                return $results;
            });
            $cache->save($cache->getItem($cacheName));

            return $results;
        }
    }

    /**
     * Supprime tous les fichiers caches liés au garage
     *
     * @throws InvalidArgumentException
     */
    public function deleteDataCache(): void
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache : delete items for Dashboard */
        $cache = new FilesystemAdapter($this->namespace, $lifetime['garage'], 'cache');
        $cache->deleteItems([
            // Garage Index
            'garages',
            // Filters
            'locked.s', 'locked.a', 'locked.b', 'locked.c', 'locked.d',
            'unlock.s', 'unlock.a', 'unlock.b', 'unlock.c', 'unlock.d',
            'to.unlock.s', 'to.unlock.a', 'to.unlock.b', 'to.unlock.c', 'to.unlock.d',
            'to.upgrade.s', 'to.upgrade.a', 'to.upgrade.b', 'to.upgrade.c', 'to.upgrade.d',
            'gold.s', 'gold.a', 'gold.b', 'gold.c', 'gold.d',
            'to.gold.s', 'to.gold.a', 'to.gold.b', 'to.gold.c', 'to.gold.d',
        ]);
    }
}
