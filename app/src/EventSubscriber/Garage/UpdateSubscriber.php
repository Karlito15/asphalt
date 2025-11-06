<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\ActualEvent;
use App\Event\Garage\GauntletEvent;
use App\Event\Garage\UpdateEvent;
use App\Service\Event\GarageAppService;
use App\Service\Event\GarageBlueprintService;
use App\Service\Event\GarageGauntletService;
use App\Service\Event\GarageStatActualService;
use App\Service\Event\GarageStatusService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly final class UpdateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private GarageAppService        $garageService,
        private GarageBlueprintService  $blueprintService,
        private GarageGauntletService   $gauntletService,
        private GarageStatActualService $statActualService,
        private GarageStatusService     $statusService,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UpdateEvent::class => [
                // Blueprint
                ['blueprint', 1200],
                // Status
                ['status', 1100],
                // Garage
                ['garage', 1000],           // Level
                // Tags
                // Orders
//                ['orderByClass', XXXX],
//                ['orderByStat', XXXX],
            ],
            GauntletEvent::class => [
                ['gauntlet', 500],
            ],
            ActualEvent::class => [
                ['statActual', 400],
            ],
        ];
    }

    public function garage(UpdateEvent $event): void
    {
        $this->garageService->levelHandler($event);
    }

    public function blueprint(UpdateEvent $event): void
    {
        $stars = $event->garage->getStars();
        switch ($stars):
            case $stars === 6:
                $this->blueprintService->isFullBlueprintStar1($event);
                $this->blueprintService->isFullBlueprintStar2($event);
                $this->blueprintService->isFullBlueprintStar3($event);
                $this->blueprintService->isFullBlueprintStar4($event);
                $this->blueprintService->isFullBlueprintStar5($event);
                $this->blueprintService->isFullBlueprintStar6($event);
                break;
            case $stars === 5:
                $this->blueprintService->isFullBlueprintStar1($event);
                $this->blueprintService->isFullBlueprintStar2($event);
                $this->blueprintService->isFullBlueprintStar3($event);
                $this->blueprintService->isFullBlueprintStar4($event);
                $this->blueprintService->isFullBlueprintStar5($event);
                break;
            case $stars === 4:
                $this->blueprintService->isFullBlueprintStar1($event);
                $this->blueprintService->isFullBlueprintStar2($event);
                $this->blueprintService->isFullBlueprintStar3($event);
                $this->blueprintService->isFullBlueprintStar4($event);
                break;

            default:
                $this->blueprintService->isFullBlueprintStar1($event);
                $this->blueprintService->isFullBlueprintStar2($event);
                $this->blueprintService->isFullBlueprintStar3($event);
                break;
        endswitch;
    }

    public function gauntlet(GauntletEvent $event): void
    {
        $this->gauntletService->calculScores($event);
    }

    public function status(UpdateEvent $event): void
    {
        $this->statusService->isUnblock($event);
        $this->statusService->isToUnblock($event);
        $this->statusService->isGold($event);
        $this->statusService->isToGold($event);

        $this->statusService->isFullUpgrade($event, 'Speed');
        $this->statusService->isToInstallUpgrade($event, 'Speed');
        $this->statusService->isFullUpgrade($event, 'Acceleration');
        $this->statusService->isToInstallUpgrade($event, 'Acceleration');
        $this->statusService->isFullUpgrade($event, 'Handling');
        $this->statusService->isToInstallUpgrade($event, 'Handling');
        $this->statusService->isFullUpgrade($event, 'Nitro');
        $this->statusService->isToInstallUpgrade($event, 'Nitro');
        $this->statusService->isFullImport($event, 'Common');
        $this->statusService->isFullImport($event, 'Rare');
        $this->statusService->isFullImport($event, 'Epic');
    }

    public function statActual(ActualEvent $event): void
    {
        $this->statActualService->copyStatMaxtoActual($event);
    }

//    public function orderByClass(UpdateEvent $event): void
//    {
//        $this->garageService->orderByClass($event, $this->manager);
//    }

//    public function orderByStat(UpdateEvent $event): void
//    {
//        $this->garageService->orderByStat($event, $this->manager);
//    }
}
