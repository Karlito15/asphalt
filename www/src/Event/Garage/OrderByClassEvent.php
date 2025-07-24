<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;

final readonly class OrderByClassEvent
{
    public function __construct(
        public GarageApp $garage
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
     * Retourne la position de la voiture dans l'ordre par Class
     *
     * @return int
     */
    public function getOrderPositionByClass(): int
    {
        return $this->garage->getCarOrder();
    }
}
