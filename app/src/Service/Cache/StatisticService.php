<?php

declare(strict_types=1);

namespace App\Service\Cache;

use App\Interface\CacheServiceInterface;
use App\Repository\GarageAppRepository;
use App\Trait\Service\Cache\CacheTrait;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Cache\ItemInterface;

class StatisticService implements CacheServiceInterface
{
    use CacheTrait;

    private string $namespace = 'statistics';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly GarageAppRepository     $repo,
    ) {}

    /**
     * Créé tous les fichiers caches liés aux statistiques
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

            $totalD          = $this->getGarageByClass('D');
            $totalC          = $this->getGarageByClass('C');
            $totalB          = $this->getGarageByClass('B');
            $totalA          = $this->getGarageByClass('A');
            $totalS          = $this->getGarageByClass('S');

            $unlockedD       = $this->getStatusByClass('D', 'unblock', true);
            $unlockedC       = $this->getStatusByClass('C', 'unblock', true);
            $unlockedB       = $this->getStatusByClass('B', 'unblock', true);
            $unlockedA       = $this->getStatusByClass('A', 'unblock', true);
            $unlockedS       = $this->getStatusByClass('S', 'unblock', true);

            $lockedD         = $this->getStatusByClass('D', 'unblock', false);
            $lockedC         = $this->getStatusByClass('C', 'unblock', false);
            $lockedB         = $this->getStatusByClass('B', 'unblock', false);
            $lockedA         = $this->getStatusByClass('A', 'unblock', false);
            $lockedS         = $this->getStatusByClass('S', 'unblock', false);

            $goldD           = $this->getStatusByClass('D', 'gold', true);
            $goldC           = $this->getStatusByClass('C', 'gold', true);
            $goldB           = $this->getStatusByClass('B', 'gold', true);
            $goldA           = $this->getStatusByClass('A', 'gold', true);
            $goldS           = $this->getStatusByClass('S', 'gold', true);

            $toUpgradeLevelD = $this->getStatusByClass('D', 'toUpgradeLevel', true);
            $toUpgradeLevelC = $this->getStatusByClass('C', 'toUpgradeLevel', true);
            $toUpgradeLevelB = $this->getStatusByClass('B', 'toUpgradeLevel', true);
            $toUpgradeLevelA = $this->getStatusByClass('A', 'toUpgradeLevel', true);
            $toUpgradeLevelS = $this->getStatusByClass('S', 'toUpgradeLevel', true);

            $toUnblockD      = $this->getStatusByClass('D', 'toUnblock', true);
            $toUnblockC      = $this->getStatusByClass('C', 'toUnblock', true);
            $toUnblockB      = $this->getStatusByClass('B', 'toUnblock', true);
            $toUnblockA      = $this->getStatusByClass('A', 'toUnblock', true);
            $toUnblockS      = $this->getStatusByClass('S', 'toUnblock', true);

            $toGoldD         = $this->getStatusByClass('D', 'toGold', true);
            $toGoldC         = $this->getStatusByClass('C', 'toGold', true);
            $toGoldB         = $this->getStatusByClass('B', 'toGold', true);
            $toGoldA         = $this->getStatusByClass('A', 'toGold', true);
            $toGoldS         = $this->getStatusByClass('S', 'toGold', true);

            $results = [
                'total'          => [
                    'D' => $totalD,
                    'C' => $totalC,
                    'B' => $totalB,
                    'A' => $totalA,
                    'S' => $totalS,
                    'Total' => $totalD + $totalC + $totalB + $totalA + $totalS
                ],
                'unblock'        => [
                    'D' => $unlockedD,
                    'C' => $unlockedC,
                    'B' => $unlockedB,
                    'A' => $unlockedA,
                    'S' => $unlockedS,
                    'Total' => $unlockedD + $unlockedC + $unlockedB + $unlockedA + $unlockedS
                ],
                'block'          => [
                    'D' => $lockedD,
                    'C' => $lockedC,
                    'B' => $lockedB,
                    'A' => $lockedA,
                    'S' => $lockedS,
                    'Total' => $lockedD + $lockedC + $lockedB + $lockedA + $lockedS
                ],
                'gold'           => [
                    'D' => $goldD,
                    'C' => $goldC,
                    'B' => $goldB,
                    'A' => $goldA,
                    'S' => $goldS,
                    'Total' => $goldD + $goldC + $goldB + $goldA + $goldS
                ],
                'toUpgradeLevel' => [
                    'D' => $toUpgradeLevelD,
                    'C' => $toUpgradeLevelC,
                    'B' => $toUpgradeLevelB,
                    'A' => $toUpgradeLevelA,
                    'S' => $toUpgradeLevelS,
                    'Total' => $toUpgradeLevelD + $toUpgradeLevelC + $toUpgradeLevelB + $toUpgradeLevelA + $toUpgradeLevelS
                ],
                'toUnblock'      => [
                    'D' => $toUnblockD,
                    'C' => $toUnblockC,
                    'B' => $toUnblockB,
                    'A' => $toUnblockA,
                    'S' => $toUnblockS,
                    'Total' => $toUnblockD + $toUnblockC + $toUnblockB + $toUnblockA + $toUnblockS
                ],
                'toGold'         => [
                    'D' => $toGoldD,
                    'C' => $toGoldC,
                    'B' => $toGoldB,
                    'A' => $toGoldA,
                    'S' => $toGoldS,
                    'Total' => $toGoldD + $toGoldC + $toGoldB + $toGoldA + $toGoldS
                ],
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
     * Supprime tous les fichiers caches liés aux statistiques
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
            'A' => $this->repo->getCarsByClass('A'),
            'B' => $this->repo->getCarsByClass('B'),
            'C' => $this->repo->getCarsByClass('C'),
            'D' => $this->repo->getCarsByClass('D'),
            default => $this->repo->getCarsByClass('S'),
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
            'A' => $this->repo->getUnblockCarsByClass('A', false),
            'B' => $this->repo->getUnblockCarsByClass('B', false),
            'C' => $this->repo->getUnblockCarsByClass('C', false),
            'D' => $this->repo->getUnblockCarsByClass('D', false),
            default => $this->repo->getUnblockCarsByClass('S', false),
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
            'A' => $this->repo->getUnblockCarsByClass('A', true),
            'B' => $this->repo->getUnblockCarsByClass('B', true),
            'C' => $this->repo->getUnblockCarsByClass('C', true),
            'D' => $this->repo->getUnblockCarsByClass('D', true),
            default => $this->repo->getUnblockCarsByClass('S', true),
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
            'A' => $this->repo->getGoldCarsByClass('A', true),
            'B' => $this->repo->getGoldCarsByClass('B', true),
            'C' => $this->repo->getGoldCarsByClass('C', true),
            'D' => $this->repo->getGoldCarsByClass('D', true),
            default => $this->repo->getGoldCarsByClass('S', true),
        };

        return count($garage);
    }

    private function getStatusByClass(string $class, string $status, bool $value): int
    {
        $garage = match ($class) {
            'A' => $this->repo->getStatusByClass('A', $status, $value),
            'B' => $this->repo->getStatusByClass('B', $status, $value),
            'C' => $this->repo->getStatusByClass('C', $status, $value),
            'D' => $this->repo->getStatusByClass('D', $status, $value),
            default => $this->repo->getStatusByClass('S', $status, $value),
        };

        return count($garage);
    }
}
