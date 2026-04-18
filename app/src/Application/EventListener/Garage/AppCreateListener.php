<?php

declare(strict_types=1);

namespace App\Application\EventListener\Garage;

use App\Application\Event\Garage\AppCreateEvent;
use App\Application\Service\Event\Garage\AddGarageRelationEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: AppCreateEvent::class,
    method: 'onGarageCreate',
    priority: 100,
)]
final class AppCreateListener
{
    public function __construct(
        protected AddGarageRelationEvent $service,
    )
    {}

    /**
     * Crée toutes les relations pour une voiture
     *
     * @param AppCreateEvent $event
     * @return void
     */
    public function onGarageCreate(AppCreateEvent $event): void
    {
        $this->service->addRelation($event);
    }
}
