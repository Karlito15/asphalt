<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\BlueprintEvent;
use App\Event\Garage\GarageEvent;
use App\Event\Garage\StatMaxEvent;
use App\Event\Garage\StatusEvent;
use App\Event\Garage\UpgradeEvent;
use App\Service\Event\Garage\StatusControlService;
use App\Service\Event\Garage\StatusService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StatusControlListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected StatusService $status,
        protected StatusControlService $control,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            BlueprintEvent::class => [
                ['controlBlueprints',   1110],
            ],
            UpgradeEvent::class   => [
                ['controlUpgrades',     1030],
                ['controlImports',      1020],
                ['toInstallUpgrades',   1010],
            ],
            GarageEvent::class => [
                ['toGoldCar',           910]
            ],
            StatMaxEvent::class => [
                ['toUnblockCar',        810]
            ],
            StatusEvent::class => [
                ['isGoldCar',           710]
            ],
        ];
    }

    public function controlBlueprints(BlueprintEvent $event): void
    {
        $this->control::FullBlueprints($event);
    }

    public function controlUpgrades(UpgradeEvent $event): void
    {
        $this->control::FullUpgrade($event, 'speed');
        $this->control::FullUpgrade($event, 'acceleration');
        $this->control::FullUpgrade($event, 'handling');
        $this->control::FullUpgrade($event, 'nitro');
    }

    public function controlImports(UpgradeEvent $event): void
    {
        $this->control::FullImport($event, 'common');
        $this->control::FullImport($event, 'rare');
        $this->control::FullImport($event, 'epic');
    }

    public function controlEvo(UpgradeEvent $event): void
    {
        // ToDo
    }

    public function toInstallUpgrades(UpgradeEvent $event): void
    {
        $this->control::InstallUpgrade($event, 'speed');
        $this->control::InstallUpgrade($event, 'acceleration');
        $this->control::InstallUpgrade($event, 'handling');
        $this->control::InstallUpgrade($event, 'nitro');
    }

    public function isGoldCar(StatusEvent $event): void
    {
        $this->status::isGold($event);
    }

    public function toUnblockCar(StatMaxEvent $event): void
    {
        $this->control::toUnblock($event);
    }

    public function toGoldCar(GarageEvent $event): void
    {
        $this->control::toGold($event);
    }
}
