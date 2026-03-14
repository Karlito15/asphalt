<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingLevel;
use App\Persistence\Entity\SettingUnitPrice;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AppCreateEvent
{
    public function __construct(
        private EntityManagerInterface $manager,
        private GarageApp $garage,
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    /**
     * @return SettingBlueprint
     */
    public function getSettingBlueprint(): SettingBlueprint
    {
        return $this->manager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => '099-99-99-99-99-99|594']);
    }

    /**
     * @return SettingLevel
     */
    public function getSettingLevel(): SettingLevel
    {
        return $this->manager->getRepository(SettingLevel::class)->findOneBy(['slug' => '99|99-99-99']);
    }

    /**
     * @return SettingUnitPrice
     */
    public function getSettingUnitPrice(): SettingUnitPrice
    {
        return $this->manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => '6999984|99999-99999-99999-99999-999999-999999']);
    }
}
