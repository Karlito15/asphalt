<?php

namespace App\Service\Cache;

use App\Interface\AsphaltCacheInterface;
use App\Repository\AppInventoryRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class InventoryCacheService implements AsphaltCacheInterface
{
    private string $namespace = 'inventories';

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly AppInventoryRepository $repository,
    ) {}

    /**
     * Créé tous les fichiers caches liés à l’inventaire
     *
     * @param string $cacheName
     * @return array
     * @throws InvalidArgumentException
     */
    public function createDataCache(string $cacheName): array
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache */
        $cache  = new FilesystemAdapter($this->namespace, $lifetime['inventory'], 'cache');
        $values = $cache->getItem($cacheName);
        if ($values->isHit()) {
            return $values->get();
        } else {
            $results   = [
                'credits'   => $this->repository->findOneBy(['slug' => 'credits']),
                'tokens'    => $this->repository->findOneBy(['slug' => 'tokens']),
                'epics'     => $this->repository->findOneBy(['slug' => 'epics']),
                'overlocks' => $this->repository->findOneBy(['slug' => 'overlocks']),
                'commons'   => $this->repository->findInventoriesByCategory('common'),
                'rares'     => $this->repository->findInventoriesByCategory('rare'),
                'jokers'    => $this->repository->findInventoriesByCategory('joker'),
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
     * Supprime tous les fichiers caches liés à l’inventaire
     *
     * @throws InvalidArgumentException
     */
    public function deleteDataCache(): void
    {
        /** Variables */
        $lifetime = $this->container->getParameter('cache_lifetime');

        /** Cache : delete items for Dashboard */
        $cache = new FilesystemAdapter($this->namespace, $lifetime['inventory'], 'cache');
        $cache->deleteItems([]);
    }
}
