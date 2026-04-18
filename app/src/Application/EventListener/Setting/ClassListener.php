<?php

declare(strict_types=1);

namespace App\Application\EventListener\Setting;

use App\Application\Event\Setting\ClassEvent;
use App\Application\Service\Event\Setting\CountCarEventByClass;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: ClassEvent::class,
    method: 'onGarageEvent',
    priority: 100,
)]
final class ClassListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        protected CountCarEventByClass $service,
    )
    {}

    /**
     * Crée toutes les relations pour une voiture
     *
     * @param ClassEvent $event
     * @return void
     */
    public function onGarageEvent(ClassEvent $event): void
    {
        $this->service->countCarsByClass($event, $this->entityManager);
    }
}
