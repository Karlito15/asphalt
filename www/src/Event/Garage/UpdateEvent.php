<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;
use App\Entity\GarageBlueprint;
use App\Entity\GarageUpgrade;
use App\Entity\SettingBlueprint;
use App\Entity\SettingLevel;

final class UpdateEvent
{
    public function __construct(
        private readonly GarageApp $garage
    )
    {
        echo $this->garage->getModel();
    }

    /**
     * Retourne la Moyenne Max de la Voiture
     *
     * @return float
     */
    public function getAverageMax(): float
    {
        return $this->garage->getStatMax()->getValues()[0]->getAverage();
    }

    /**
     * Retourne la Médiane de la Class de la Voiture
     *
     * @return int
     */
    public function getMedian(): int
    {
        return $this->garage->getSettingClass()->getMedian();
    }

    /**
     * @return GarageBlueprint
     */
    public function getBlueprint(): GarageBlueprint
    {
        return $this->garage->getBlueprint()->getValues()[0];
    }

    /**
     * @return GarageUpgrade
     */
    public function getUpgrade(): GarageUpgrade
    {
        return $this->garage->getUpgrade()->getValues()[0];
    }

    /**
     * @return SettingBlueprint
     */
    public function getSettingBlueprint(): SettingBlueprint
    {
        return $this->garage->getSettingBlueprint();
    }

    /**
     * @return SettingLevel
     */
    public function getSettingLevel(): SettingLevel
    {
        return $this->garage->getSettingLevel();
    }
}
