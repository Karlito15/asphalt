<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\StatusEvent;
use App\Service\Event\Garage\StatusService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StatusListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected StatusService $status,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            StatusEvent::class => [
                ['isUnblockCar', 2000],
            ],
        ];
    }

    public function isUnblockCar(StatusEvent $event): void
    {
        $this->status::isUnblock($event);
    }
}
