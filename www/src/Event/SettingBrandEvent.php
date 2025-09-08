<?php

namespace App\Event;

use App\Entity\AppGarage;

readonly class SettingBrandEvent
{
    public function __construct(public AppGarage $garage) {}

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
