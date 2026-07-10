<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Event\Garage\AppEvent;
use App\Infrastructure\Event\Garage\StatisticalEvent;
use App\Infrastructure\Service\Cron\Event\Garage\Blueprint;
use App\Infrastructure\Service\Cron\Event\Garage\Evo;
use App\Infrastructure\Service\Cron\Event\Garage\Gauntlet;
use App\Infrastructure\Service\Cron\Event\Garage\Level;
use App\Infrastructure\Service\Cron\Event\Garage\Price;
use App\Infrastructure\Service\Cron\Event\Garage\Upgrade;
use App\Infrastructure\Service\Cron\Statistical\Garage;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class GarageAppListener
{
    public function __construct(
        protected Blueprint $blueprint,
        protected Evo $evo,
        protected Gauntlet $gauntlet,
        protected Level $level,
        protected Price $price,
        protected Upgrade $upgrade,
        protected Garage $statistical,
    )
    {}

    /**
     * Vérifie si le nombre de cartes pour la première étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 1003)]
    public function onUpdateUnblock(AppEvent $event): void
    {
        $this->blueprint::statusUnblock($event);
    }

    /**
     * Vérifie pour chaque étoile si le nombre de cartes nécessaires est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 1002)]
    public function onUpdateBlueprint(AppEvent $event): void
    {
        $this->blueprint::statusControlFullStar2($event);
        $this->blueprint::statusControlFullStar3($event);
        $this->blueprint::statusControlFullStar4($event);
        $this->blueprint::statusControlFullStar5($event);
        $this->blueprint::statusControlFullStar6($event);
    }

    /**
     * Vérifie si le nombre total de cartes est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 1001)]
    public function onUpdateFullBlueprint(AppEvent $event): void
    {
        $this->blueprint::statusControlFullBlueprint($event);
    }

    /**
     * Vérifie si tous les blueprints sont completés niveau par niveau
     * Met à jour automatiquement le Level de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 901)]
    public function onUpdateGarageLevel(AppEvent $event): void
    {
        $this->level::getLevel($event);
    }

    /**
     * XXX
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 803)]
    public function onUpdateInstallUpgrade(AppEvent $event): void
    {
        $this->upgrade::statusControlUpgrade($event);
        $this->upgrade::statusControlFullUpgrade($event);
    }

    /**
     * Vérifie si toutes les conditions sont remplies pour la voiture Gold
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 802)]
    public function onUpdateStatusGold(AppEvent $event): void
    {
        $this->upgrade::statusGold($event);
    }

    /**
     * Vérifie si toutes les conditions sont remplies pour installer toutes les évolutions de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 801)]
    public function onUpdateToGold(AppEvent $event): void
    {
        $this->upgrade::statusToGold($event);
    }

    /**
     * Vérifie si le nombre d'évolutions sont installés
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 202)]
    public function onUpdateFullEvo(AppEvent $event): void
    {
        $this->evo::statusControlEvo($event);
    }

    /**
     * En fonction des Stats Max, on détermine un score pour chaque paramètre et un score global
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 201)]
    public function onUpdateGauntletMark(AppEvent $event): void
    {
        $this->gauntlet::mark($event);
    }

    /**
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 102)]
    public function onUpdateCost(AppEvent $event): void
    {
        $this->price->paid($event);
        $this->price->due($event);
        $this->price->amount($event);
    }

    /**
     * @return void
     */
    #[AsEventListener(event: StatisticalEvent::class, priority: 101)]
    public function onUpdateStatistical(): void
    {
        $this->statistical->countGarageByClass();
        $this->statistical->countGarageBlockByClass();
        $this->statistical->countGarageUnblockByClass();
        $this->statistical->countGarageGoldByClass();
        $this->statistical->countGarageToUpgradeByClass();
        $this->statistical->countGarageEvoByClass();
        $this->statistical->countGarageFullBlueprintByClass();
    }
}
