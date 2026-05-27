<?php

namespace App\Infrastructure\Data\Garage;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\GarageBlueprint;
use App\Domain\Entity\GarageGauntlet;
use App\Domain\Entity\GarageRank;
use App\Domain\Entity\GarageStatActual;
use App\Domain\Entity\GarageStatMax;
use App\Domain\Entity\GarageStatMin;
use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\GarageStatusControl;
use App\Domain\Entity\GarageUpgrade;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Entity\SettingLevel;
use App\Domain\Entity\SettingUnitPrice;
use Doctrine\ORM\EntityManagerInterface;

class App
{
    public static function create(EntityManagerInterface $entityManager, array $datas): GarageApp
    {
        $entity = new GarageApp();
        self::setterApp($entity, $datas, $entityManager);
        ### Relation
        $entity->setSettingBlueprint($entityManager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => '000-00-00-00-00-00|000']));
        $entity->setSettingBrand($entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $datas['Brand']]));
        $entity->setSettingClass($entityManager->getRepository(SettingClass::class)->findOneBy(['slug' => $datas['SettingClass']]));
        $entity->setSettingLevel($entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => '00|00-00-00']));
        $entity->setSettingUnitPrice($entityManager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => '0000000']));

        return $entity;
    }

    public static function createSettingBlueprint(EntityManagerInterface $entityManager, array $datas): GarageApp
    {
        ### Garage
        $entity = self::findGarage($datas, $entityManager);
        $entity->setSettingBlueprint(
            $entityManager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $datas['SettingBlueprint']])
        );

        return $entity;
    }

    public static function createSettingLevel(EntityManagerInterface $entityManager, array $datas): GarageApp
    {
        ### Garage
        $entity = self::findGarage($datas, $entityManager);
        $entity->setSettingLevel(
            $entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => $datas['SettingLevel']])
        );

        return $entity;
    }

    public static function createSettingUnitPrice(EntityManagerInterface $entityManager, array $datas): GarageApp
    {
        ### Garage
        $entity = self::findGarage($datas, $entityManager);
        $entity->setSettingUnitPrice(
            $entityManager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => $datas['SettingPrice']])
        );

        return $entity;
    }

    public static function createBlueprint(EntityManagerInterface $entityManager, array $datas): GarageBlueprint
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageBlueprint();
        $entity->setStar1(self::NullToZero($datas['Star1']));
        $entity->setStar2((int) $datas['Star2']);
        $entity->setStar3((int) $datas['Star3']);
        if ($garage->getStars() === 4) {
            $entity->setStar4((int) $datas['Star4']);
        }

        if ($garage->getStars() === 5) {
            $entity->setStar4((int) $datas['Star4']);
            $entity->setStar5((int) $datas['Star5']);
        }

        if ($garage->getStars() === 6) {
            $entity->setStar4((int) $datas['Star4']);
            $entity->setStar5((int) $datas['Star5']);
            $entity->setStar6((int) $datas['Star6']);
        }

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createGauntlet(EntityManagerInterface $entityManager, array $datas): GarageGauntlet
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageGauntlet();
        $entity
            ->setSpeed((int) $datas['Speed'])
            ->setAcceleration((int) $datas['Acceleration'])
            ->setHandling((int) $datas['Handling'])
            ->setNitro((int) $datas['Nitro'])
            ->setMark((int) $datas['Mark'])
            ->setDivision((int) $datas['Division'])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createRank(EntityManagerInterface $entityManager, array $datas): GarageRank
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageRank();
        $entity
            ->setStar0((int) $datas['Star0'])
            ->setStar1((int) $datas['Star1'])
            ->setStar2((int) $datas['Star2'])
            ->setStar3((int) $datas['Star3'])
        ;
        if ($garage->getStars() === 4) {
            $entity->setStar4((int) $datas['Star4']);
        }

        if ($garage->getStars() === 5) {
            $entity->setStar4((int) $datas['Star4']);
            $entity->setStar5((int) $datas['Star5']);
        }

        if ($garage->getStars() === 6) {
            $entity->setStar4((int) $datas['Star4']);
            $entity->setStar5((int) $datas['Star5']);
            $entity->setStar6((int) $datas['Star6']);
        }

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createStatActual(EntityManagerInterface $entityManager, array $datas): GarageStatActual
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageStatActual();
        $entity
            ->setSpeed((float) $datas['Speed'])
            ->setAcceleration((float) $datas['Acceleration'])
            ->setHandling((float) $datas['Handling'])
            ->setNitro((float) $datas['Nitro'])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createStatMax(EntityManagerInterface $entityManager, array $datas): GarageStatMax
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageStatMax();
        $entity
            ->setSpeed((float) $datas['Speed'])
            ->setAcceleration((float) $datas['Acceleration'])
            ->setHandling((float) $datas['Handling'])
            ->setNitro((float) $datas['Nitro'])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createStatMin(EntityManagerInterface $entityManager, array $datas): GarageStatMin
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageStatMin();
        $entity
            ->setSpeed((float) $datas['Speed'])
            ->setAcceleration((float) $datas['Acceleration'])
            ->setHandling((float) $datas['Handling'])
            ->setNitro((float) $datas['Nitro'])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createStatus(EntityManagerInterface $entityManager, array $datas): GarageStatus
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageStatus();
        $entity
            ->setUnblock((bool) $datas['Unblock'])
            ->setGold((bool) $datas['Gold'])
            ->setEvo((bool) $datas['Evo'])
            ->setEventClass((bool) $datas['EventClass'])
            ->setToUpgrade((bool) $datas['ToUpgrade'])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createStatusControl(EntityManagerInterface $entityManager, array $datas): GarageStatusControl
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageStatusControl();

        $entity->setGarage($garage);

        return $entity;
    }

    public static function createUpgrade(EntityManagerInterface $entityManager, array $datas): GarageUpgrade
    {
        $garage = self::findGarage($datas, $entityManager);

        $entity = new GarageUpgrade();
        $entity
            ->setSpeed((int) $datas['Speed'])
            ->setAcceleration((int) $datas['Acceleration'])
            ->setHandling((int) $datas['Handling'])
            ->setNitro((int) $datas['Nitro'])
            ->setCommon((int) $datas["Common"])
            ->setRare((int) $datas["Rare"])
            ->setEpic((int) $datas["Epic"])
        ;

        $entity->setGarage($garage);

        return $entity;
    }

    public static function update(EntityManagerInterface $entityManager, GarageApp $entity, array $datas): GarageApp
    {
        self::setterApp($entity, $datas, $entityManager);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param GarageApp $entity
     * @param array $datas
     * @param EntityManagerInterface $manager
     * @return void
     */
    private static function setterApp(GarageApp $entity, array $datas, EntityManagerInterface $manager): void
    {
        $entity->setStars((int) $datas['Stars']);
        $entity->setGameUpdate((int) $datas['GameUpdate']);
        $entity->setCarOrder((int) $datas['CarOrder']);
        $entity->setStatOrder((int) $datas['StatOrder']);
        $entity->setModel((string) $datas['Model']);
        $entity->setLevel((int) $datas['Level']);
        $entity->setEpic((int) $datas['Epic']);
    }

    /**
     * @param array $datas
     * @param EntityManagerInterface $manager
     * @return GarageApp
     */
    private static function findGarage(array $datas, EntityManagerInterface $manager): GarageApp
    {
        if (is_null($datas['Brand'])) {
            throw new \RuntimeException('Brand cannot be null :: ' . $datas['Brand']);
        }

        if (is_null($datas['Model'])) {
            throw new \RuntimeException('Model cannot be null :: ' . $datas['Model']);
        }

        return $manager->getRepository(GarageApp::class)->findOneByBrandAndModel($datas['Brand'], $datas['Model']);
    }

    private static function NullToZero(?string $value = null): string
    {
        if ($value === 'NULL' OR $value === null) {
            return '0';
        }

        return $value;
    }
}
