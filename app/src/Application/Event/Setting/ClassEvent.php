<?php

declare(strict_types=1);

namespace App\Application\Event\Setting;

use App\Domain\Entity\GarageApp;

final readonly class ClassEvent
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
	 * Retourne la Class de la Voiture
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->garage->getSettingClass()->getValue();
    }

    /**
	 * Retourne la Médiane de la Voiture
     *
     * @return int
     */
    public function getMedian(): int
    {
        return $this->garage->getSettingClass()->getMedian();
    }
}
