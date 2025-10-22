<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Interface\CacheServiceInterface;
use App\Repository\MissionAppRepository;
use App\Trait\Service\Cache\CacheTrait;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MissionAppService implements CacheServiceInterface
{
    use CacheTrait;

    private string $namespace = 'missions';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly MissionAppRepository    $repository,
    )
    {
    }

    /**
     * Créé tous les fichiers caches liés aux missions
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
            $results = $this->repository->findAll();

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
     * Supprime tous les fichiers caches liés aux missions
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
            $e->getMessage();
        }
    }
}
