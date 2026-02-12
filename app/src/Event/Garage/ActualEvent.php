<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageStatActual;
use App\Persistence\Entity\GarageStatMax;
use App\Persistence\Entity\GarageStatus;

final readonly class ActualEvent
{
    public function __construct(
        public GarageApp $garage
    ) {}

    /**
     * @return GarageStatus
     */
    public function getStatus(): GarageStatus
    {
        return $this->garage->getStatus()->getValues()[0];
    }

    /**
     * Retourne le GarageStatActual de la Voiture
     *
     * @return GarageStatActual
     */
    public function getStatActual(): GarageStatActual
    {
        return $this->garage->getStatActual()->getValues()[0];
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
