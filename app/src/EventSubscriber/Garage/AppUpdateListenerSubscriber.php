<?php

declare(strict_types=1);

namespace App\EventSubscriber\Garage;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;

class AppUpdateListenerSubscriber implements EventSubscriberInterface
{
    public function onFormSubmit(SubmitEvent $event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.submit' => 'onFormSubmit',
        ];
    }
}
