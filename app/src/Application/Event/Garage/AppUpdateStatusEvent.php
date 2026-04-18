<?php

declare(strict_types=1);

namespace App\Application\Event\Garage;

use App\Domain\Entity\GarageApp;

final readonly class AppUpdateStatusEvent
{
    public function __construct(
        private GarageApp $garage,
    ) {}

    ### Garage

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    ### Garage Blueprint

    /**
     * Retourne la valeur du Garage pour les Blueprints Star 1
     *
     * @return int|string
     */
    public function getGarageStar1(): int|string
    {
        if (is_null($this->garage->getBlueprint()->getStar1())) {
            exit($this->garage->getModel());
        }
        return $this->garage->getBlueprint()->getStar1();
    }

    ### Setting Blueprint

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
