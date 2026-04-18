<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Garage;

use App\Application\Event\Garage\AppUpdateGauntletEvent;

final class GauntletEvent
{
    /**
     * Mets à jour automatiquement la table Garage Gauntlet en fonction des valeurs stats max
     *
     * @param AppUpdateGauntletEvent $event
     * @return void
     */
    public static function updateGarageGauntlet(AppUpdateGauntletEvent $event): void
    {
        ### Get Values
        $garage       = $event->getGarage();
        $speed        = $event->getSpeed();
        $acceleration = $event->getAcceleration();
        $handling     = $event->getHandling();
        $nitro        = $event->getNitro();

        ### Score Speed
        $speed = match (true) {
            $speed >= 400 => 1,
            $speed >= 350 => 2,
            $speed >= 300 => 3,
            $speed < 300 => 9,
        };
        $garage->getGauntlet()->setSpeed($speed);

        ### Score Acceleration
        $acceleration = match (true) {
            $acceleration >= 86 => 1,
            $acceleration >= 83 => 2,
            $acceleration >= 80 => 3,
            $acceleration < 80 => 9,
        };
        $garage->getGauntlet()->setAcceleration($acceleration);

        ### Score Handling
        $handling = match (true) {
            $handling >= 80 => 1,
            $handling >= 60 => 2,
            $handling >= 40 => 3,
            $handling < 40 => 9,
        };
        $garage->getGauntlet()->setHandling($handling);

        ### Score Nitro
        $nitro = match (true) {
            $nitro >= 75 => 1,
            $nitro >= 60 => 2,
            $nitro >= 45 => 3,
            $nitro < 45 => 9,
        };
        $garage->getGauntlet()->setNitro($nitro);

        ### Score Mark
        $average = (($speed + $acceleration + $handling + $nitro) / 4);
        $mark    = floor($average);
        $garage->getGauntlet()->setMark((int)$mark);
    }
}
