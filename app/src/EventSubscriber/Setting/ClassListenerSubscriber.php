<?php

declare(strict_types=1);

namespace App\EventSubscriber\Setting;

use App\Event\Setting\ClassEvent;
use App\Service\Event\Setting\ClassService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class ClassListenerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ClassService           $classService,
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            ClassEvent::class  => 'countCarsByClass',
        ];
    }

    public function countCarsByClass(ClassEvent $event): void
    {
        $this->classService->countCarsByClass($event, $this->entityManager);
    }
}
