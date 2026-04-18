<?php

declare(strict_types=1);

namespace App\Application\Event\Garage;

use App\Domain\Entity\GarageApp;

//use Doctrine\ORM\EntityManagerInterface;

final readonly class AppUpdateBlueprintEvent
{
    public function __construct(
//        private EntityManagerInterface $manager,
        private GarageApp $garage,
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    ### Garage

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
     * Retourne le nombre d'étoiles de la voiture
     *
     * @return int
     */
    public function getStars(): int
    {
        return $this->garage->getStars();
    }

    /**
     * Retourne le level de la voiture
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->garage->getLevel();
    }

    ### Garage Blueprint

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
}
