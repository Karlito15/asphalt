<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;

final readonly class StatusEvent
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
     * Retourne la valeur du Garage pour les Blueprints Star 1
     *
     * @return int|string
     */
    public function getGarageStar1(): int|string
    {
        return $this->garage->getBlueprint()->getStar1();
    }

    /**
     * Retourne la valeur Cible pour les Blueprints Star 1
     *
     * @return int|string
     */
    public function getSettingStar1(): int|string
    {
        return $this->garage->getSettingBlueprint()->getStar1();
    }
}
