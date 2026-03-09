<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Persistence\Entity\GarageApp;

final readonly class UnitPriceEvent
{
    public function __construct(
//        private EntityManagerInterface $manager
        private GarageApp $garage
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

//    /**
//	 * Retourne le Unit-Price par défault de la Voiture
//     *
//     * @return SettingUnitPrice
//     */
//    public function getClass(): SettingUnitPrice
//    {
//        return $this->manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => '6999984|99999-99999-99999-99999-999999-999999']);
//    }

    public function getLevel01(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel01();
    }

    public function getLevel02(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel02();
    }

    public function getLevel03(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel03();
    }

    public function getLevel04(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel04();
    }

    public function getLevel05(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel05();
    }

    public function getLevel06(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel06();
    }

    public function getLevel07(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel07();
    }

    public function getLevel08(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel08();
    }

    public function getLevel09(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel09();
    }

    public function getLevel10(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel10();
    }

    public function getLevel11(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel11();
    }

    public function getLevel12(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel12();
    }

    public function getLevel13(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel13();
    }

    public function getCommon(): int
    {
        return $this->garage->getSettingUnitPrice()->getCommon();
    }

    public function getRare(): int
    {
        return $this->garage->getSettingUnitPrice()->getRare();
    }

    public function getEpic(): int
    {
        return $this->garage->getSettingUnitPrice()->getEpic();
    }
}
