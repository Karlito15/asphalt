<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Entity\GarageApp;

final class BrandEvent
{
    public function __construct(
        private readonly GarageApp $garage
    )
    {
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
