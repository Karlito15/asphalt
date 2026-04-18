<?php

declare(strict_types=1);

namespace App\Application\EventSubscriber\Garage;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;

class AppUpdateSubscriber implements EventSubscriberInterface
{
    public function onFormPostSubmit(PostSubmitEvent $event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.post_submit' => 'onFormPostSubmit',
        ];
    }
}
