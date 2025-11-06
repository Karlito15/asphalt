<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Event\Garage\ActualEvent;

class GarageStatActualService
{
    public function copyStatMaxtoActual(ActualEvent $event): void
    {
        /**
         * Get Values
         */
        $garage       = $event->garage;
        $statActual   = $event->getStatActual();
        $statMax      = $event->getStatMax();
        $status       = $event->getStatus();

        if (($garage instanceof GarageApp) && $status->isGold() === true) {
            $statActual->setSpeed($statMax->getSpeed());
            $statActual->setAcceleration($statMax->getAcceleration());
            $statActual->setHandling($statMax->getHandling());
            $statActual->setNitro($statMax->getNitro());
            $statActual->setAverage($statMax->getSpeed(), $statMax->getAcceleration(), $statMax->getHandling(), $statMax->getNitro());
        }
    }
}
