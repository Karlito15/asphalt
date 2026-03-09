<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;

final readonly class BlueprintEvent
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
     * Retourne la valeur du Garage pour les Blueprints
     *
     * @return array<string, int>
     */
    public function getGarageStars(): array
    {
        return [
            'star1' => $this->garage->getBlueprint()->getStar1(),
            'star2' => $this->garage->getBlueprint()->getStar2(),
            'star3' => $this->garage->getBlueprint()->getStar3(),
            'star4' => $this->garage->getBlueprint()->getStar4(),
            'star5' => $this->garage->getBlueprint()->getStar5(),
            'star6' => $this->garage->getBlueprint()->getStar6(),
            'total' => $this->garage->getBlueprint()->getTotal(),
        ];
    }

    /**
     * Retourne la valeur du Garage pour les Settings
     *
     * @return array<string, int>
     */
    public function getSettingStars(): array
    {
        return [
            'star1' => $this->garage->getSettingBlueprint()->getStar1(),
            'star2' => $this->garage->getSettingBlueprint()->getStar2(),
            'star3' => $this->garage->getSettingBlueprint()->getStar3(),
            'star4' => $this->garage->getSettingBlueprint()->getStar4(),
            'star5' => $this->garage->getSettingBlueprint()->getStar5(),
            'star6' => $this->garage->getSettingBlueprint()->getStar6(),
            'total' => $this->garage->getSettingBlueprint()->getTotal(),
        ];
    }
}
