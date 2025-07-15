<?php

namespace App\EventListener\Garage;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class CreateListener
{
    #[AsEventListener]
    public function onRequestEvent(RequestEvent $event): void
    {
        // ...
    }
}
