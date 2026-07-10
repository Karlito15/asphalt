<?php

declare(strict_types=1);

namespace App\Application\Service\Cache;

use App\Domain\Interface\CacheInterface;
use App\Domain\Repository\GarageAppRepository;
use App\Domain\Repository\InventoryAppRepository;
use App\Domain\Repository\MissionAppRepository;
use App\Domain\Repository\MissionTaskRepository;
use App\Domain\Repository\MissionTypeRepository;
use App\Domain\Repository\RaceAppRepository;
use App\Domain\Repository\RaceModeRepository;
use App\Domain\Repository\RaceRegionRepository;
use App\Domain\Repository\RaceSeasonRepository;
use App\Domain\Repository\RaceTimeRepository;
use App\Domain\Repository\RaceTrackRepository;
use App\Domain\Repository\SettingBlueprintRepository;
use App\Domain\Repository\SettingBrandRepository;
use App\Domain\Repository\SettingClassRepository;
use App\Domain\Repository\SettingLevelRepository;
use App\Domain\Repository\SettingTagRepository;
use App\Domain\Repository\SettingUnitPriceRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SitemapCache implements CacheInterface
{
    use ServiceCache;

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
