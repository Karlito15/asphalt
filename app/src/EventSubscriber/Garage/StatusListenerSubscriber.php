<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use App\Event\Garage\AppUpdateEvent;
use App\Service\Event\Garage\AppUpdateService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StatusListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected AppUpdateService $update,
    )
    {}

    public static function getSubscribedEvents(): array
    {

        return [
            AppUpdateEvent::class   => [
                ['onUpdateStatusUnblock',                   1020],
                ['onUpdateStatusGold',                      1010],
            ],
        ];
    }

    public function onUpdateStatusUnblock(AppUpdateEvent $event): void
    {
        $this->update::StatusUnblock($event);
    }

    public function onUpdateStatusGold(AppUpdateEvent $event): void
    {
        $this->update::StatusGold($event);
    }
}
