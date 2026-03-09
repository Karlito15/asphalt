<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\AppCreateEvent;
use App\Service\Event\Garage\GarageAppService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class AppCreateListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected GarageAppService       $garageService,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            AppCreateEvent::class => 'onGarageCreate',
        ];
    }

    public function onGarageCreate(AppCreateEvent $event): void
    {
        $this->garageService->initGarage($event, $this->entityManager);
    }
}
