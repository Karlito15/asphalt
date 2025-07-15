<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;

final class OrderByStatEvent
{
    public function __construct(
        private readonly GarageApp $garage
    )
    {
    }

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
     * Retourne la position de la voiture dans l'ordre par Stat (Average Max)
     *
     * @return int
     */
    public function getOrderPositionByStat(): int
    {
        return $this->garage->getStatOrder();
    }
}
