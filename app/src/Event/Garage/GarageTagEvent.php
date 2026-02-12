<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\GarageUpgrade;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingLevel;

final class GarageTagEvent
{
    public function __construct(public GarageApp $garage)
    {
    }

    /**
     * @return float
     */
    public function getAverageMax(): float
    {
        return $this->garage->getStatMax()->getValues()[0]->getAverage();
    }

    /**
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
