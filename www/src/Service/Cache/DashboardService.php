<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Able\Service\Cache\CacheAble;
use App\Interface\ServiceCacheInterface;
use App\Repository\GarageAppRepository;
use App\Repository\InventoryAppRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * On retourne les données pour le dashboard
 *
 */
class DashboardService implements ServiceCacheInterface
{
    use CacheAble;

    private string $namespace = 'dashboards';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly GarageAppRepository     $garages,
        private readonly InventoryAppRepository  $inventories,
    )
    {
    }

    /**
     * Créé tous les fichiers caches liés au dashboard
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function cacheCreate(): array
    {
        // Get LifeTime Cache
        $lifetime = $this->getCacheLifeTime($this->namespace);

        // Cache
        $cache  = new FilesystemAdapter($this->namespace, $lifetime, 'cache');
        try {
            $values = $cache->getItem($this->namespace);
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
        }

        if ($values->isHit()) {
            return $values->get();
        } else {
            $totalD = $this->getGarageByClass('D');
            $totalC = $this->getGarageByClass('C');
            $totalB = $this->getGarageByClass('B');
            $totalA = $this->getGarageByClass('A');
            $totalS = $this->getGarageByClass('S');

            $unlockedD = $this->getUnlockedByClass('D');
            $unlockedC = $this->getUnlockedByClass('C');
            $unlockedB = $this->getUnlockedByClass('B');
            $unlockedA = $this->getUnlockedByClass('A');
            $unlockedS = $this->getUnlockedByClass('S');

            $lockedD = $this->getLockedByClass('D');
            $lockedC = $this->getLockedByClass('C');
            $lockedB = $this->getLockedByClass('B');
            $lockedA = $this->getLockedByClass('A');
            $lockedS = $this->getLockedByClass('S');

            $goldD = $this->getGoldByClass('D');
            $goldC = $this->getGoldByClass('C');
            $goldB = $this->getGoldByClass('B');
            $goldA = $this->getGoldByClass('A');
            $goldS = $this->getGoldByClass('S');

            $results = [
                'total'     => [
                    'D' => $totalD,
                    'C' => $totalC,
                    'B' => $totalB,
                    'A' => $totalA,
                    'S' => $totalS,
                    'Total' => $totalD + $totalC + $totalB + $totalA + $totalS
                ],
                'unlock'    => [
                    'D' => $unlockedD,
                    'C' => $unlockedC,
                    'B' => $unlockedB,
                    'A' => $unlockedA,
                    'S' => $unlockedS,
                    'Total' => $unlockedD + $unlockedC + $unlockedB + $unlockedA + $unlockedS
                ],
                'lock'      => [
                    'D' => $lockedD,
                    'C' => $lockedC,
                    'B' => $lockedB,
                    'A' => $lockedA,
                    'S' => $lockedS,
                    'Total' => $lockedD + $lockedC + $lockedB + $lockedA + $lockedS
                ],
                'gold'      => [
                    'D' => $goldD,
                    'C' => $goldC,
                    'B' => $goldB,
                    'A' => $goldA,
                    'S' => $goldS,
                    'Total' => $goldD + $goldC + $goldB + $goldA + $goldS
                ],
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

    /**
     * Liste des voitures par Class
     *
     * @param string $class
     * @return int
     */
    private function getGarageByClass(string $class): int
    {
        $garage = match ($class) {
            'A' => $this->garages->getCarsByClass('A'),
            'B' => $this->garages->getCarsByClass('B'),
            'C' => $this->garages->getCarsByClass('C'),
            'D' => $this->garages->getCarsByClass('D'),
            default => $this->garages->getCarsByClass('S'),
        };

        return count($garage);
    }

    /**
     * Liste des voitures non débloquées par Class
     *
     * @param string $class
     * @return int
     */
    private function getLockedByClass(string $class): int
    {
        $garage = match ($class) {
            'A' => $this->garages->getCarsUnlockedByClass('A', false),
            'B' => $this->garages->getCarsUnlockedByClass('B', false),
            'C' => $this->garages->getCarsUnlockedByClass('C', false),
            'D' => $this->garages->getCarsUnlockedByClass('D', false),
            default => $this->garages->getCarsUnlockedByClass('S', false),
        };

        return count($garage);
    }

    /**
     * Liste des voitures débloquées par Class
     *
     * @param string $class
     * @return int
     */
    private function getUnlockedByClass(string $class): int
    {
        $garage = match ($class) {
            'A' => $this->garages->getCarsUnlockedByClass('A', true),
            'B' => $this->garages->getCarsUnlockedByClass('B', true),
            'C' => $this->garages->getCarsUnlockedByClass('C', true),
            'D' => $this->garages->getCarsUnlockedByClass('D', true),
            default => $this->garages->getCarsUnlockedByClass('S', true),
        };

        return count($garage);
    }

    /**
     * Liste des voitures gold par Class
     *
     * @param string $class
     * @return int
     */
    private function getGoldByClass(string $class): int
    {
        $garage = match ($class) {
            'A' => $this->garages->getCarsGoldByClass('A', true),
            'B' => $this->garages->getCarsGoldByClass('B', true),
            'C' => $this->garages->getCarsGoldByClass('C', true),
            'D' => $this->garages->getCarsGoldByClass('D', true),
            default => $this->garages->getCarsGoldByClass('S', true),
        };

        return count($garage);
    }
}
