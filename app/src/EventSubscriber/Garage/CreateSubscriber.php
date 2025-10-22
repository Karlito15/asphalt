<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\CreateEvent;
use App\Event\Setting\BrandEvent;
use App\Event\Setting\ClassEvent;
use App\Service\Event\GarageAppService;
use App\Service\Event\SettingBrandService;
use App\Service\Event\SettingClassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly final class CreateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private GarageAppService $garageService,
        private SettingBrandService $brandService,
        private SettingClassService $classService,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            BrandEvent::class  => 'countCarsByBrand',
            ClassEvent::class  => 'countCarsByClass',
            CreateEvent::class => 'onGarageCreate',
        ];
    }

    public function countCarsByBrand(BrandEvent $event): void
    {
        $this->brandService->countCarsByBrand($event, $this->entityManager);
    }

    public function countCarsByClass(ClassEvent $event): void
    {
        $this->classService->countCarsByClass($event, $this->entityManager);
    }

    public function onGarageCreate(CreateEvent $event): void
    {
        $this->garageService->initGarage($event, $this->entityManager);
    }
}
