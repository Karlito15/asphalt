<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;
use App\Entity\GarageStatActual;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatus;

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
     * @return GarageStatActual
     */
    public function getStatActual(): GarageStatActual
    {
        return $this->garage->getStatActual()->getValues()[0];
    }

    /**
     * @return GarageStatMax
     */
    public function getStatMax(): GarageStatMax
    {
        return $this->garage->getStatMax()->getValues()[0];
    }
}
