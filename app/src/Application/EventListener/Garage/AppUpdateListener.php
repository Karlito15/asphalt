<?php

declare(strict_types=1);

namespace App\Application\EventListener\Garage;

use App\Application\Event\Garage\AppUpdateGauntletEvent;
use App\Application\Event\Garage\AppUpdateLevelEvent;
use App\Application\Event\Garage\AppUpdateStatusControlEvent;
use App\Application\Event\Garage\AppUpdateStatusEvent;
use App\Application\Service\Event\Garage\GauntletEvent;
use App\Application\Service\Event\Garage\LevelEvent;
use App\Application\Service\Event\Garage\StatusControlEvent;
use App\Application\Service\Event\Garage\StatusEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class AppUpdateListener
{
    public function __construct(
        protected GauntletEvent $gauntlet,
        protected StatusEvent $status,
        protected StatusControlEvent $statusControl,
        protected LevelEvent $level,
    )
    {}

    /**
     * Met à jour l'entité GarageGauntlet
     *
     * @param AppUpdateGauntletEvent $event
     * @return void
     */
    #[AsEventListener(event: AppUpdateGauntletEvent::class)]
    public function onUpdateGauntlet(AppUpdateGauntletEvent $event): void
    {
        $this->gauntlet::updateGarageGauntlet($event);
    }

    /**
     * Met à jour l'entité GarageStatus
     *
     * @param AppUpdateStatusEvent $event
     * @return void
     */
    #[AsEventListener(event: AppUpdateStatusEvent::class)]
    public function onUpdateStatus(AppUpdateStatusEvent $event): void
    {
        $this->status::updateGarageStatusUnblock($event);
        $this->status::updateGarageStatusGold($event);
    }

    /**
     * Met à jour l'entité GarageStatusControl
     *
     * @param AppUpdateStatusControlEvent $event
     * @return void
     */
    #[AsEventListener(event: AppUpdateStatusControlEvent::class)]
    public function onUpdateStatusControl(AppUpdateStatusControlEvent $event): void
    {
        $this->statusControl::updateGarageStatusControlBlueprint($event);
        $this->statusControl::updateGarageStatusControlEvo($event);
        $this->statusControl::updateGarageStatusControlImport($event, 'common');
        $this->statusControl::updateGarageStatusControlImport($event, 'rare');
        $this->statusControl::updateGarageStatusControlImport($event, 'epic');
        $this->statusControl::updateGarageStatusControlToGold($event);
        $this->statusControl::updateGarageStatusControlToInstallImports($event);
        $this->statusControl::updateGarageStatusControlToInstallImports($event);
        $this->statusControl::updateGarageStatusControlToInstallImports($event);
        $this->statusControl::updateGarageStatusControlToInstallUpgrades($event, 'speed');
        $this->statusControl::updateGarageStatusControlToInstallUpgrades($event, 'acceleration');
        $this->statusControl::updateGarageStatusControlToInstallUpgrades($event, 'handling');
        $this->statusControl::updateGarageStatusControlToInstallUpgrades($event, 'nitro');
        $this->statusControl::updateGarageStatusControlUpgrade($event, 'speed');
        $this->statusControl::updateGarageStatusControlUpgrade($event, 'acceleration');
        $this->statusControl::updateGarageStatusControlUpgrade($event, 'handling');
        $this->statusControl::updateGarageStatusControlUpgrade($event, 'nitro');
    }

    /**
     * Met à jour l'entité Garage
     *
     * @param AppUpdateLevelEvent $event
     * @return void
     */
    #[AsEventListener(event: AppUpdateLevelEvent::class)]
    public function onUpdateLevel(AppUpdateLevelEvent $event): void
    {
        $this->level::updateGarageLevel($event);
    }
}
