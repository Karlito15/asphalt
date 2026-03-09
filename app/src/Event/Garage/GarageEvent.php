<?php

declare(strict_types=1);

namespace App\Event\Garage;

use App\Persistence\Entity\GarageApp;

final readonly class GarageEvent
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

    /**
     * Retourne le nombre de cartes Epic de la voiture
     *
     * @return int
     */
    public function getEpic(): int
    {
        return $this->garage->getEpic();
    }

    /**
     * Retourne le nombre de cartes Evo de la voiture
     *
     * @return int
     */
    public function getEvo(): int
    {
        return $this->garage->getEvo();
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
}
