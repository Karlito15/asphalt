<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Persistence\Entity\GarageApp;

final readonly class BrandEvent
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
     * Retourne la Marque de la Voiture
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->garage->getSettingBrand()->getName();
    }
}
