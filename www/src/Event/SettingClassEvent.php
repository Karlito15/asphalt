<?php

namespace App\Event;

use App\Entity\AppGarage;

readonly class SettingClassEvent
{
    public function __construct(public AppGarage $garage) {}

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
