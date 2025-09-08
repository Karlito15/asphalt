<?php

namespace App\Event;

use App\Entity\AppGarage;
use App\Entity\GarageBlueprint;
use App\Entity\GarageUpgrade;
use App\Entity\SettingBlueprint;
use App\Entity\SettingLevel;

readonly class BooleanGarageEvent
{
    public function __construct(public AppGarage $garage) {}

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
