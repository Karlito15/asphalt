<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageGauntlet;
use App\Persistence\Entity\GarageStatMax;

final readonly class GauntletEvent
{
    public function __construct(
        public GarageApp $garage
    ) {}

    /**
     * Retourne le GarageGauntlet de la Voiture
     *
     * @return GarageGauntlet
     */
    public function getGauntlet(): GarageGauntlet
    {
        return $this->garage->getGauntlet()->getValues()[0];
    }

    /**
     * Retourne le GarageStatMax de la Voiture
     *
     * @return GarageStatMax
     */
    public function getStatMax(): GarageStatMax
    {
        return $this->garage->getStatMax()->getValues()[0];
    }
}
