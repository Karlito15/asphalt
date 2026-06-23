<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Event\Garage\SettingEvent;
use App\Infrastructure\Service\Cron\Event\Setting\Count;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class SettingListener
{
    public function __construct(
        protected Count $count,
        protected EntityManagerInterface $entityManager,
    )
    {}

    /**
     * Compte le nombre de voitures par Brand
     *
     * @param SettingEvent $event
     * @return void
     */
    #[AsEventListener(event: SettingEvent::class, priority: 200)]
    public function onUpdateBrand(SettingEvent $event): void
    {
        $this->count::byBrand($event, $this->entityManager);
    }

    /**
     * Compte le nombre de voitures par Class
     *
     * @param SettingEvent $event
     * @return void
     */
    #[AsEventListener(event: SettingEvent::class, priority: 100)]
    public function onUpdateClass(SettingEvent $event): void
    {
        $this->count::byClass($event, $this->entityManager);
    }
}
