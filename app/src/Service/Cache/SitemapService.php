<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Interface\CacheServiceInterface;
use App\Repository\GarageAppRepository;
use App\Repository\InventoryAppRepository;
use App\Repository\MissionAppRepository;
use App\Repository\MissionTaskRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\RaceAppRepository;
use App\Repository\RaceModeRepository;
use App\Repository\RaceRegionRepository;
use App\Repository\RaceSeasonRepository;
use App\Repository\RaceTimeRepository;
use App\Repository\RaceTrackRepository;
use App\Repository\SettingBlueprintRepository;
use App\Repository\SettingBrandRepository;
use App\Repository\SettingClassRepository;
use App\Repository\SettingLevelRepository;
use App\Repository\SettingTagRepository;
use App\Repository\SettingUnitPriceRepository;
use App\Trait\Service\Cache\CacheTrait;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class SitemapService implements CacheServiceInterface
{
    use CacheTrait;

    private string $namespace = 'sitemaps';

    public function __construct(
        private readonly ContainerInterface         $container,
        private readonly GarageAppRepository        $garages,
        private readonly MissionAppRepository       $missions,
        private readonly RaceAppRepository          $races,
        private readonly InventoryAppRepository     $inventories,
        private readonly MissionTaskRepository      $tasks,
        private readonly MissionTypeRepository      $types,
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
    {
    }

    /**
     * Créé tous les fichiers caches liés au sitemaps
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
                'garages'     => $this->garages->sitemapDatas(),
                'missions'    => $this->missions->sitemapDatas(),
                'races'       => $this->races->sitemapDatas(),
                'inventories' => $this->inventories->sitemapDatas(),
                'tasks'       => $this->tasks->sitemapDatas(),
                'types'       => $this->types->sitemapDatas(),
                'modes'       => $this->modes->sitemapDatas(),
                'regions'     => $this->regions->sitemapDatas(),
                'seasons'     => $this->seasons->sitemapDatas(),
                'times'       => $this->times->sitemapDatas(),
                'tracks'      => $this->tracks->sitemapDatas(),
                'blueprints'  => $this->blueprints->sitemapDatas(),
                'brands'      => $this->brands->sitemapDatas(),
                'classes'     => $this->classes->sitemapDatas(),
                'levels'      => $this->levels->sitemapDatas(),
                'tags'        => $this->tags->sitemapDatas(),
                'unitPrices'  => $this->unitPrices->sitemapDatas(),
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
            echo $e->getMessage();
        }
    }
}
