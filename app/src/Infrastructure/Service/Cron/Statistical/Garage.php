<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Statistical;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\SettingClass;
use App\Domain\Entity\StatisticalGarage;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Garage
{
    public function __construct(
        private EntityManagerInterface $manager,
    )
    {}

    public function countGarageByClass(): void
    {
        $name = 'garage-alls';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => $this->manager->getRepository(GarageApp::class)->countByClass('D'),
           'C' => $this->manager->getRepository(GarageApp::class)->countByClass('C'),
           'B' => $this->manager->getRepository(GarageApp::class)->countByClass('B'),
           'A' => $this->manager->getRepository(GarageApp::class)->countByClass('A'),
           'S' => $this->manager->getRepository(GarageApp::class)->countByClass('S'),
           'T' => $this->manager->getRepository(GarageApp::class)->countByClass('T'),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
        $this->manager->clear();
    }

    public function countGarageBlockByClass(): void
    {
        $name = 'garage-blocks';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => $this->getGarageStatusEntity('D', 'unblock', false),
           'C' => $this->getGarageStatusEntity('C', 'unblock', false),
           'B' => $this->getGarageStatusEntity('B', 'unblock', false),
           'A' => $this->getGarageStatusEntity('A', 'unblock', false),
           'S' => $this->getGarageStatusEntity('S', 'unblock', false),
           'T' => $this->getGarageStatusEntity('T', 'unblock', false),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageUnblockByClass(): void
    {
        $name = 'garage-unblocks';
        $stat = $this->initClass($name);

        $stat->setValue([
           'D' => $this->getGarageStatusEntity('D', 'unblock', true),
           'C' => $this->getGarageStatusEntity('C', 'unblock', true),
           'B' => $this->getGarageStatusEntity('B', 'unblock', true),
           'A' => $this->getGarageStatusEntity('A', 'unblock', true),
           'S' => $this->getGarageStatusEntity('S', 'unblock', true),
           'T' => $this->getGarageStatusEntity('T', 'unblock', true),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageGoldByClass(): void
    {
        $name = 'garage-golds';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => $this->getGarageStatusEntity('D', 'gold', true),
           'C' => $this->getGarageStatusEntity('C', 'gold', true),
           'B' => $this->getGarageStatusEntity('B', 'gold', true),
           'A' => $this->getGarageStatusEntity('A', 'gold', true),
           'S' => $this->getGarageStatusEntity('S', 'gold', true),
           'T' => $this->getGarageStatusEntity('T', 'gold', true),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageToUpgradeByClass(): void
    {
        $name = 'garage-to-upgrades';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => $this->getGarageStatusEntity('D', 'toUpgrade', true),
           'C' => $this->getGarageStatusEntity('C', 'toUpgrade', true),
           'B' => $this->getGarageStatusEntity('B', 'toUpgrade', true),
           'A' => $this->getGarageStatusEntity('A', 'toUpgrade', true),
           'S' => $this->getGarageStatusEntity('S', 'toUpgrade', true),
           'T' => $this->getGarageStatusEntity('T', 'toUpgrade', true),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageEvoByClass(): void
    {
        $name = 'garage-evos';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => $this->getGarageStatusEntity('D', 'evo', true),
           'C' => $this->getGarageStatusEntity('D', 'evo', true),
           'B' => $this->getGarageStatusEntity('D', 'evo', true),
           'A' => $this->getGarageStatusEntity('D', 'evo', true),
           'S' => $this->getGarageStatusEntity('D', 'evo', true),
           'T' => $this->getGarageStatusEntity('T', 'evo', true),
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageFullBlueprintByClass(): void
    {
        $name = 'garage-full-blueprints';
        $stat = $this->initClass($name);
        $stat->setValue([
           'D' => 0,
           'C' => 0,
           'B' => 0,
           'A' => 0,
           'S' => 0,
           'T' => 0,
        ]);

        $this->manager->persist($stat);
        $this->manager->flush();
    }

    public function countGarageFullUpgradeByClass(): void
    {

    }

    public function countGarageFullImportByClass(): void
    {

    }

    /** PRIVATE METHODS */

    /**
     * @param string $name
     * @return StatisticalGarage
     */
    private function initClass(string $name): StatisticalGarage
    {
        $q = $this->manager->getRepository(StatisticalGarage::class)->findOneBy(['name' => $name]);
        if ($q === null) {
            $stat = new StatisticalGarage();
            $stat->setName($name);

            return $stat;
        }

        return $q;
    }

    /**
     * @param string $classValue
     * @param string $column
     * @param bool $choice
     * @return int
     */
    private function getGarageStatusEntity(string $classValue, string $column, bool $choice): int
    {
        $garage = $this->getGarageEntity($classValue);

        return count($this->manager->getRepository(GarageStatus::class)->findBy([$column => $choice, 'garage' => $garage]));
    }

    /**
     * @param string $criteria
     * @return array<GarageApp>
     */
    private function getGarageEntity(string $criteria): array
    {
        if ($criteria === 'T') {
            return $this->manager->getRepository(GarageApp::class)->findAll();
        }

        $class = $this->getSettingClassEntity($criteria);

        return $this->manager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
    }

    /**
     * @param string $criteria
     * @return SettingClass
     */
    private function getSettingClassEntity(string $criteria): SettingClass
    {
        return $this->manager->getRepository(SettingClass::class)->findOneBy(['value' => $criteria]);
    }
}
