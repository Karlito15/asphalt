<?php

declare(strict_types=1);

namespace App\Event\Setting;

use App\Entity\GarageApp;

final readonly class ClassEvent
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
}
