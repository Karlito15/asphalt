<?php

declare(strict_types=1);

namespace App\Application\EventListener\Setting;

use App\Application\Event\Setting\BrandEvent;
use App\Application\Service\Event\Setting\CountCarEventByBrand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(
    event: BrandEvent::class,
    method: 'onGarageEvent',
    priority: 100,
)]
final class BrandListener
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        protected CountCarEventByBrand $service,
    )
    {}

    /**
     * Crée toutes les relations pour une voiture
     *
     * @param BrandEvent $event
     * @return void
     */
    public function onGarageEvent(BrandEvent $event): void
    {
        $this->service->countCarsByBrand($event, $this->entityManager);
    }
}
