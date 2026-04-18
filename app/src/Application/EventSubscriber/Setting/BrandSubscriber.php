<?php

declare(strict_types=1);

namespace App\Application\EventSubscriber\Setting;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;

class BrandSubscriber implements EventSubscriberInterface
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
