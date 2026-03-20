<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Persistence\Repository\GarageAppRepository;
use App\Persistence\Repository\InventoryAppRepository;
use App\Persistence\Repository\MissionAppRepository;
use App\Persistence\Repository\MissionTaskRepository;
use App\Persistence\Repository\MissionTypeRepository;
use App\Persistence\Repository\RaceAppRepository;
use App\Persistence\Repository\RaceModeRepository;
use App\Persistence\Repository\RaceRegionRepository;
use App\Persistence\Repository\RaceSeasonRepository;
use App\Persistence\Repository\RaceTimeRepository;
use App\Persistence\Repository\RaceTrackRepository;
use App\Persistence\Repository\SettingBlueprintRepository;
use App\Persistence\Repository\SettingBrandRepository;
use App\Persistence\Repository\SettingClassRepository;
use App\Persistence\Repository\SettingLevelRepository;
use App\Persistence\Repository\SettingTagRepository;
use App\Persistence\Repository\SettingUnitPriceRepository;
use App\Service\Interface\CacheServiceInterface;
use App\Toolbox\Trait\Service\CacheService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SitemapService implements CacheServiceInterface
{
    use CacheService;

    private string $namespace = 'sitemaps';

    public function __construct(
        private readonly ContainerInterface         $container,
        private readonly GarageAppRepository        $garages,
        private readonly InventoryAppRepository     $inventories,
        private readonly MissionAppRepository       $missions,
        private readonly MissionTaskRepository      $tasks,
        private readonly MissionTypeRepository      $types,
        private readonly RaceAppRepository          $races,
        private readonly RaceModeRepository         $modes,
        private readonly RaceRegionRepository       $regions,
        private readonly RaceSeasonRepository       $seasons,
        private readonly RaceTimeRepository         $times,
        private readonly RaceTrackRepository        $tracks,
        private readonly SettingBlueprintRepository $blueprints,
        private readonly SettingBrandRepository     $brands,
        private readonly SettingClassRepository     $classes,
        private readonly SettingLevelRepository     $levels,
        private readonly SettingTagRepository       $tags,
        private readonly SettingUnitPriceRepository $unitPrices,
    )
    {}

    /**
     * Créé tous les fichiers caches liés au sitemaps
     *
     * @return array
     */
    public function cacheCreate(): array
    {
        ### Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        ### Cache
        $cache  = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $values = $cache->getItem($this->namespace);

            if ($values->isHit()) {
                return $values->get();
            }

            ### Requête à mettre en cache
            $results = [];
            $results = [
                'garages'     => $this->garages->sitemap(),
                'inventories' => $this->inventories->sitemap(),
                'missions'    => $this->missions->sitemap(),
                'tasks'       => $this->tasks->sitemap(),
                'types'       => $this->types->sitemap(),
                'races'       => $this->races->sitemap(),
                'modes'       => $this->modes->sitemap(),
                'regions'     => $this->regions->sitemap(),
                'seasons'     => $this->seasons->sitemap(),
                'times'       => $this->times->sitemap(),
                'tracks'      => $this->tracks->sitemap(),
                'blueprints'  => $this->blueprints->sitemap(),
                'brands'      => $this->brands->sitemap(),
                'classes'     => $this->classes->sitemap(),
                'levels'      => $this->levels->sitemap(),
                'tags'        => $this->tags->sitemap(),
                'unitPrices'  => $this->unitPrices->sitemap(),
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
     * Supprime tous les fichiers caches liés au sitemaps
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
            throw new \RuntimeException($e->getMessage());
        }
    }
}
