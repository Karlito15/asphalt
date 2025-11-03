<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Entity\GarageApp;
use App\Entity\GarageBlueprint;
use App\Entity\GarageStatus;
use App\Entity\GarageUpgrade;
use App\Entity\SettingBlueprint;
use App\Entity\SettingLevel;

final readonly class UpdateEvent
{
    public function __construct(
        public GarageApp $garage
    ) {}

    /**
     * Retourne l'id de la voiture
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->garage->getId();
    }

    /**
     * Retourne la position de la voiture dans sa Class
     *
     * @return int
     */
    public function getOrderPositionByClass(): int
    {
        return $this->garage->getCarOrder();
    }

    /**
     * Retourne la position de la voiture par Stat (Average Max)
     *
     * @return int
     */
    public function getOrderPositionByStat(): int
    {
        return $this->garage->getStatOrder();
    }

    /**
     * @return GarageBlueprint
     */
    public function getBlueprint(): GarageBlueprint
    {
        return $this->garage->getBlueprint()->getValues()[0];
    }

    /**
     * @return GarageStatus
     */
    public function getStatus(): GarageStatus
    {
        return $this->garage->getStatus()->getValues()[0];
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
	 * Retourne la Class de la Voiture
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->garage->getSettingClass()->getValue();
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
     * @return SettingLevel
     */
    public function getSettingLevel(): SettingLevel
    {
        return $this->garage->getSettingLevel();
    }
}
