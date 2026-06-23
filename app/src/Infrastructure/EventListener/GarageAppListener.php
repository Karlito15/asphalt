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
     * XXX
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 900)]
    public function onUpdateInstallUpgrade(AppEvent $event): void
    {
        $this->upgrade::statusControlUpgrade($event);
        $this->upgrade::statusControlFullUpgrade($event);
    }

    /**
     * XXX
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 800)]
    public function onUpdateToGold(AppEvent $event): void
    {
        $this->upgrade::statusToGold($event);
    }

    /**
     * Vérifie si toutes les conditions sont remplies pour la voiture Gold
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 700)]
    public function onUpdateStatusGold(AppEvent $event): void
    {
        ### Variables
        $status  = $event->getGarage()->getStatus();
        $control = $event->getGarage()->getStatusControl();

        ### Conditions
        if ($control->isFullBlueprint() && $control->isFullUpgrade() && $control->isFullImport()):
            $status->setGold(true);
        else:
            $status->setGold(false);
        endif;
    }

    /**
     * Vérifie pour chaque étoile si le nombre de cartes nécessaires est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 600)]
    public function onUpdateBlueprint(AppEvent $event): void
    {
        $this->blueprint::statusControlBlueprint($event);
    }

    /**
     * Met à jour automatiquement le Level de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 500)]
    public function onUpdateGarageLevel(AppEvent $event): void
    {
        $this->level::getLevel($event);
    }

    /**
     * Vérifie si le nombre total de cartes est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 400)]
    public function onUpdateFullBlueprint(AppEvent $event): void
    {
        $this->blueprint::statusControlFullBlueprint($event);
    }

    /**
     * Vérifie si le nombre de cartes pour la première étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 300)]
    public function onUpdateUnblock(AppEvent $event): void
    {
        $this->blueprint::statusUnblock($event);
    }

    /**
     * Vérifie si le nombre d'évolutions sont installés
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 200)]
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
    #[AsEventListener(event: AppEvent::class, priority: 100)]
    public function onUpdateGauntletMark(AppEvent $event): void
    {
        $this->gauntlet::mark($event);
    }

    /**
     *
     * @param AppEvent $event
     * @return void
     */
    #[AsEventListener(event: AppEvent::class, priority: 20)]
    public function onUpdateCost(AppEvent $event): void
    {
        $this->price->paid($event);
        $this->price->due($event);
        $this->price->amount($event);
    }

    /**
     * @return void
     */
    #[AsEventListener(event: StatisticalEvent::class, priority: 10)]
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
