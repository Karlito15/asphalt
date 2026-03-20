<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\AppUpdateEvent;
use App\Service\Event\Garage\AppUpdateService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AppUpdateListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected AppUpdateService $update,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            AppUpdateEvent::class   => [
                ['onUpdateGarageLevel',                     2060],
                ['onUpdateStatusControlBlueprint',          2050],
                ['onUpdateStatusControlEvo',                2046],
                ['onUpdateStatusControlGauntlet',           2045],
                ['onUpdateStatusControlImport',             2044],
                ['onUpdateStatusControlToGold',             2043],
                ['onUpdateStatusControlToInstallImports',   2042],
                ['onUpdateStatusControlToInstallUpgrades',  2041],
                ['onUpdateStatusControlToUnblock',          2030],
                ['onUpdateStatusControlUpgrade',            2020],
//                ['onUpdateCopyStatMaxToStatActual',         2010],
            ],
        ];
    }

    public function onUpdateGarageLevel(AppUpdateEvent $event): void
    {
        $this->update::GarageLevel($event);
    }

    public function onUpdateStatusControlBlueprint(AppUpdateEvent $event): void
    {
        $this->update::StatusControlBlueprint($event);
    }

    public function onUpdateStatusControlEvo(AppUpdateEvent $event): void
    {
        $this->update::StatusControlEvo($event);
    }

    public function onUpdateStatusControlGauntlet(AppUpdateEvent $event): void
    {
        $this->update::StatusControlGauntlet($event);
    }

    public function onUpdateStatusControlImport(AppUpdateEvent $event): void
    {
        $this->update::StatusControlImport($event, 'common');
        $this->update::StatusControlImport($event, 'rare');
        $this->update::StatusControlImport($event, 'epic');
    }

    public function onUpdateStatusControlToGold(AppUpdateEvent $event): void
    {
        $this->update::StatusControlToGold($event);
    }

    public function onUpdateStatusControlToInstallImports(AppUpdateEvent $event): void
    {
        $this->update::StatusControlToInstallImports($event);
        $this->update::StatusControlToInstallImports($event);
        $this->update::StatusControlToInstallImports($event);
    }

    public function onUpdateStatusControlToInstallUpgrades(AppUpdateEvent $event): void
    {
        $this->update::StatusControlToInstallUpgrades($event, 'speed');
        $this->update::StatusControlToInstallUpgrades($event, 'acceleration');
        $this->update::StatusControlToInstallUpgrades($event, 'handling');
        $this->update::StatusControlToInstallUpgrades($event, 'nitro');
    }

    public function onUpdateStatusControlToUnblock(AppUpdateEvent $event): void
    {
        $this->update::StatusControlToUnblock($event);
    }

    public function onUpdateStatusControlUpgrade(AppUpdateEvent $event): void
    {
        $this->update::StatusControlUpgrade($event, 'speed');
        $this->update::StatusControlUpgrade($event, 'acceleration');
        $this->update::StatusControlUpgrade($event, 'handling');
        $this->update::StatusControlUpgrade($event, 'nitro');
    }

    public function onUpdateCopyStatMaxToStatActual(AppUpdateEvent $event): void
    {
        $this->update::copyStatMaxToStatActual($event);
    }
}
