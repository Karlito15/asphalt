<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Garage;

use App\Application\Event\Garage\AppUpdateStatusEvent;

final class StatusEvent
{
    /**
     * Détermine si la voiture est débloquée
     *
     * @param AppUpdateStatusEvent $event
     * @return void
     */
    public static function updateGarageStatusUnblock(AppUpdateStatusEvent $event): void
    {
        ### Variables
        $status = $event->getGarage()->getStatus();

        ### Conditions
        if ($event->getGarageStar1() === $event->getSettingStar1()):
            $status->setUnblock(true);
        else:
            $status->setUnblock(false);
        endif;
    }

    /**
     * Détermine si la voiture est gold
     *
     * Détermine si tous les imports & les upgrades de la voiture sont installés
     *
     * @param AppUpdateStatusEvent $event
     * @return void
     */
    public static function updateGarageStatusGold(AppUpdateStatusEvent $event): void
    {
        ### Variables
        $status  = $event->getGarage()->getStatus();
        $control = $event->getGarage()->getStatusControl();

        ### Conditions
        if (
            $control->isFullBlueprint() &&
            $control->isFullUpgrade() &&
            $control->isFullImport()
        ):
            $status->setGold(true);
        else:
            $status->setGold(false);
        endif;
    }
}
