<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\GarageStatus;
use App\Persistence\Entity\GarageUpgrade;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingLevel;

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
     * Retourne le GarageBlueprint de la Voiture
     *
     * @return GarageBlueprint
     */
    public function getBlueprint(): GarageBlueprint
    {
        return $this->garage->getBlueprint()->getValues()[0];
    }

    /**
     * Retourne le GarageStatus de la Voiture
     *
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
     * Retourne le GarageUpgrade de la Voiture
     *
     * @return GarageUpgrade
     */
    public function getUpgrade(): GarageUpgrade
    {
        return $this->garage->getUpgrade()->getValues()[0];
    }

    /**
     * Retourne le SettingBlueprint de la Voiture
     *
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
     * Retourne le SettingLevel de la Voiture
     *
     * @return SettingLevel
     */
    public function getSettingLevel(): SettingLevel
    {
        return $this->garage->getSettingLevel();
    }
}
