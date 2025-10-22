<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\UpdateEvent;
use App\Service\Event\GarageAppService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly final class UpdateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $manager,
        private GarageAppService $garageService,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UpdateEvent::class => [
                // States
                ['isUnlocked', 1099],
                ['isGold', 1098],
                // Tags
                ['isToUnlock', 1089],
                ['isToGold', 1088],
                ['isFullBlueprint', 1079],
                ['isFullSpeed', 1078],
                ['isFullAcceleration', 1077],
                ['isFullHandling', 1076],
                ['isFullNitro', 1075],
                ['isFullCommon', 1074],
                ['isFullRare', 1073],
                ['isFullEpic', 1072],
                ['isFullAllUpgrades', 1069],
                ['isFullAllImports', 1068],
                // Orders
                ['orderByClass', 1010],
                ['orderByStat', 1000],
            ],
        ];
    }

    public function orderByClass(UpdateEvent $event): void
    {
        $this->garageService->orderByClass($event, $this->manager);
    }

    public function orderByStat(UpdateEvent $event): void
    {
        $this->garageService->orderByStat($event, $this->manager);
    }

    public function isUnlocked(UpdateEvent $event): void
    {
        $this->garageService->isUnlocked($event);
    }

    public function isGold(UpdateEvent $event): void
    {
        $this->garageService->isGold($event);
    }

    public function isToUnlock(UpdateEvent $event): void
    {
        $this->garageService->isToUnlock($event, $this->manager);
    }

    public function isToGold(UpdateEvent $event): void
    {
        $this->garageService->isToGold($event, $this->manager);
    }

    public function isFullBlueprint(UpdateEvent $event): void
    {
        $this->garageService->isFullBlueprint($event, $this->manager);
    }

    public function isFullSpeed(UpdateEvent $event): void
    {
        $this->garageService->isFullUpgrade($event, $this->manager, 'Speed');
    }

    public function isFullAcceleration(UpdateEvent $event): void
    {
        $this->garageService->isFullUpgrade($event, $this->manager, 'Acceleration');
    }

    public function isFullHandling(UpdateEvent $event): void
    {
        $this->garageService->isFullUpgrade($event, $this->manager, 'Handling');
    }

    public function isFullNitro(UpdateEvent $event): void
    {
        $this->garageService->isFullUpgrade($event, $this->manager, 'Nitro');
    }

    public function isFullCommon(UpdateEvent $event): void
    {
        $this->garageService->isFullImport($event, $this->manager, 'Common');
    }

    public function isFullRare(UpdateEvent $event): void
    {
        $this->garageService->isFullImport($event, $this->manager, 'Rare');
    }

    public function isFullEpic(UpdateEvent $event): void
    {
        $this->garageService->isFullImport($event, $this->manager, 'Epic');
    }

    public function isFullAllUpgrades(UpdateEvent $event): void
    {
        $this->garageService->isFullAllUpgrades($event, $this->manager);
    }

    public function isFullAllImports(UpdateEvent $event): void
    {
        $this->garageService->isFullAllImports($event, $this->manager);
    }
}
