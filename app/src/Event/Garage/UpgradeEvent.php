<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;

final readonly class UpgradeEvent
{
    public function __construct(
        private GarageApp $garage
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    /**
     * Retourne le Level de la Voiture
     *
     * @return int
     */
    public function getGarageLevel(): int
    {
        return $this->garage->getLevel();
    }

    /**
     * Retourne les Upgrades de la Voiture
     *
     * @return array<string, int>
     */
    public function getGarageUpgrade(): array
    {
        return [
            'speed'        => $this->garage->getUpgrade()->getSpeed(),
            'acceleration' => $this->garage->getUpgrade()->getAcceleration(),
            'handling'     => $this->garage->getUpgrade()->getHandling(),
            'nitro'        => $this->garage->getUpgrade()->getNitro(),
            'common'       => $this->garage->getUpgrade()->getCommon(),
            'rare'         => $this->garage->getUpgrade()->getRare(),
            'epic'         => $this->garage->getUpgrade()->getEpic(),
        ];
    }

    /**
     * Retourne les Upgrades de la Voiture
     *
     * @return array<string, int>
     */
    public function getSettingUpgrade(): array
    {
        return [
            'level'        => $this->garage->getSettingLevel()->getLevel(),
            'common'       => $this->garage->getSettingLevel()->getCommon(),
            'rare'         => $this->garage->getSettingLevel()->getRare(),
            'epic'         => $this->garage->getSettingLevel()->getEpic(),
        ];
    }
}
