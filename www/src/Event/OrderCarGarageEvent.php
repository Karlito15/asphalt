<?php

namespace App\Event;

use App\Entity\AppGarage;

readonly class OrderCarGarageEvent
{
    public function __construct(public AppGarage $garage) {}

    /**
     * Retourne la Class de la Voiture
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->garage->getSettingClass()->getValue();
    }

    /**
     * Retourne la position de la voiture dans l'ordre par Class
     *
     * @return int
     */
    public function getOrderPositionByClass(): int
    {
        return $this->garage->getCarOrder();
    }

    /**
     * Retourne la position de la voiture dans l'ordre par Stat (Average Max)
     *
     * @return int
     */
    public function getOrderPositionByStat(): int
    {
        return $this->garage->getStatOrder();
    }
}
