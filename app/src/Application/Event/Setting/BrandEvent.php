<?php

declare(strict_types=1);

namespace App\Application\Event\Setting;

use App\Domain\Entity\GarageApp;

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
    public function getBrand(): string
    {
        return $this->garage->getSettingBrand()->getName();
    }
}
