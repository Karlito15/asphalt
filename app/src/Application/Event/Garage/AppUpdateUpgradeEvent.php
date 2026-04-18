<?php

declare(strict_types=1);

namespace App\Application\Event\Garage;

use App\Domain\Entity\GarageApp;

//use Doctrine\ORM\EntityManagerInterface;

final readonly class AppUpdateUpgradeEvent
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

    ### Garage Blueprint

    /**
     * Retourne la valeur du Garage pour les Blueprints Star 1
     *
     * @return int|string
     */
    public function getGarageStar1(): int|string
    {
        return $this->garage->getBlueprint()->getStar1();
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

    ### Garage Stat Max

    /**
     * Retourne la vitesse du Garage pour les Stats Max
     *
     * @return float
     */
    public function getSpeed(): float
    {
        return $this->garage->getStatMax()->getSpeed();
    }

    /**
     * Retourne l'accélération du Garage pour les Stats Max
     *
     * @return float
     */
    public function getAcceleration(): float
    {
        return $this->garage->getStatMax()->getAcceleration();
    }

    /**
     * Retourne la maniabilité du Garage pour les Stats Max
     *
     * @return float
     */
    public function getHandling(): float
    {
        return $this->garage->getStatMax()->getHandling();
    }

    /**
     * Retourne la nitro du Garage pour les Stats Max
     *
     * @return float
     */
    public function getNitro(): float
    {
        return $this->garage->getStatMax()->getNitro();
    }

    /**
     * Retourne la moyenne du Garage pour les Stats Max
     *
     * @return float
     */
    public function getAverage(): float
    {
        return $this->garage->getStatMax()->getAverage();
    }

    ### Garage Upgrade

    /**
     * Retourne les Upgrades de la Voiture
     *
     * @return array<string, int>
     */
    public function getGarageUpgrade(): array
    {
        return [
            'speed'        => $this->garage->getUpgrade()->getSpeed(),
            'acceleration' => $this->garage->getUpgrade()->getAcceleration(),
            'handling'     => $this->garage->getUpgrade()->getHandling(),
            'nitro'        => $this->garage->getUpgrade()->getNitro(),
            'common'       => $this->garage->getUpgrade()->getCommon(),
            'rare'         => $this->garage->getUpgrade()->getRare(),
            'epic'         => $this->garage->getUpgrade()->getEpic(),
        ];
    }

    /**
     * Retourne les Upgrades de la Voiture
     *
     * @return array<string, int>
     */
    public function getSettingUpgrade(): array
    {
        return [
            'level'        => $this->garage->getSettingLevel()->getLevel(),
            'common'       => $this->garage->getSettingLevel()->getCommon(),
            'rare'         => $this->garage->getSettingLevel()->getRare(),
            'epic'         => $this->garage->getSettingLevel()->getEpic(),
        ];
    }

    ### Setting Blueprint

    /**
     * Retourne la valeur Cible pour les Blueprints Star 1
     *
     * @return int|string
     */
    public function getSettingStar1(): int|string
    {
        return $this->garage->getSettingBlueprint()->getStar1();
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
