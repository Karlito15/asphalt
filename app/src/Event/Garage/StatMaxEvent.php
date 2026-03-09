<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;

final readonly class StatMaxEvent
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
     * Retourne la vitesse du Garage pour les Stats Max
     *
     * @return float
     */
    public function getSpeed(): float
    {
        return $this->garage->getStatMax()->$this->getSpeed();
    }

    /**
     * Retourne l'accélération du Garage pour les Stats Max
     *
     * @return float
     */
    public function getAcceleration(): float
    {
        return $this->garage->getStatMax()->getAcceleration();
    }

    /**
     * Retourne la maniabilité du Garage pour les Stats Max
     *
     * @return float
     */
    public function getHandling(): float
    {
        return $this->garage->getStatMax()->getHandling();
    }

    /**
     * Retourne la nitro du Garage pour les Stats Max
     *
     * @return float
     */
    public function getNitro(): float
    {
        return $this->garage->getStatMax()->getNitro();
    }

    /**
     * Retourne la moyenne du Garage pour les Stats Max
     *
     * @return float
     */
    public function getAverage(): float
    {
        return $this->garage->getStatMax()->getAverage();
    }
}
