<?php

declare(strict_types=1);

namespace App\Application\Event\Garage;

use App\Domain\Entity\GarageApp;

final readonly class AppUpdateLevelEvent
{
    public function __construct(
        private GarageApp $garage,
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    ### Garage

    /**
     * Retourne le nombre d'étoiles de la voiture
     *
     * @return int
     */
    public function getStars(): int
    {
        return $this->garage->getStars();
    }
}
