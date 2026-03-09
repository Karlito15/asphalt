<?php

declare(strict_types=1);

namespace App\EventSubscriber\Setting;

use App\Event\Setting\BrandEvent;
use App\Service\Event\Setting\BrandService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class BrandListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private BrandService           $brandService,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            BrandEvent::class  => 'countCarsByBrand',
        ];
    }

    public function countCarsByBrand(BrandEvent $event): void
    {
        $this->brandService->countCarsByBrand($event, $this->entityManager);
    }
}
