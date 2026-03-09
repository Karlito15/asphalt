<?php

declare(strict_types=1);

namespace App\Service\Event\Garage;

use App\Event\Garage\StatusEvent;

class StatusService
{
    /**
     * Détermine si la voiture est débloquée
     *
     * @param StatusEvent $event
     * @return void
     */
    public static function isUnblock(StatusEvent $event): void
    {
        // Variables
        $status  = $event->getGarage()->getStatus();

        if ($event->getGarageStar1() === $event->getSettingStar1()) {
            $status->setUnblock(true);
        } else {
            $status->setUnblock(false);
        }
    }

    /**
     * Détermine si la voiture est gold
     *
     * @param StatusEvent $event
     * @return void
     */
    public static function isGold(StatusEvent $event): void
    {
        // Variables
        $status  = $event->getGarage()->getStatus();
        $control = $event->getGarage()->getStatusControl();

        if (
            $control->isFullBlueprint() &&
            $control->isFullUpgrade() &&
            $control->isFullImport()
        ) {
            $status->setGold(true);
        } else {
            $status->setGold(false);
        }
    }
}
