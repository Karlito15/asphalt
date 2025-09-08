<?php

namespace App\Service\Cache;

use App\Interface\AsphaltCacheInterface;
use App\Repository\AppRaceRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RaceCacheService implements AsphaltCacheInterface
{
    private string $namespace = 'races';

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly AppRaceRepository  $repository,
    ) {}

    /**
     * Créé tous les fichiers caches liés aux courses
     *
     * @throws InvalidArgumentException
     */
    public function createDataCache(string $cacheName): array
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache */
        $cache = new FilesystemAdapter($this->namespace, $lifetime['race'], 'cache');
        $values = $cache->getItem($cacheName);
        if ($values->isHit()) {
            return $values->get();
        } else {
            $results   = [
                'index'     => $this->repository->getRaces(),
            ];

            $cache->get($cacheName, function (ItemInterface $item) use ($results) {
                $item->expiresAt(new \DateTime('+30 days'));
                $item->set($results);

                return $results;
            });
            $cache->save($cache->getItem($cacheName));

            return $results;
        }
    }

    /**
     * Supprime tous les fichiers caches liés aux courses
     *
     * @throws InvalidArgumentException
     */
    public function deleteDataCache(): void
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache : delete items for Dashboard */
        $cache = new FilesystemAdapter($this->namespace, $lifetime['race'], 'cache');
        $cache->deleteItem($this->namespace);
    }
}
