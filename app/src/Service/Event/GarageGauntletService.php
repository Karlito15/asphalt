<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Event\Garage\GauntletEvent;

class GarageGauntletService
{
    public function calculScores(GauntletEvent $event): void
    {
        /**
         * Get Values
         */
        $garage       = $event->garage;
        $stats        = $event->getStatMax();
        $speed        = $stats->getSpeed();
        $acceleration = $stats->getAcceleration();
        $handling     = $stats->getHandling();
        $nitro        = $stats->getNitro();

        if ($garage instanceof GarageApp) {
            // Score Speed
            $score = match (true) {
                $speed >= 400 => 1,
                $speed >= 350 => 2,
                $speed >= 300 => 3,
                $speed < 300 => 9,
            };
            $event->getGauntlet()->setSpeed($score);
            // Score Acceleration
            $score = match (true) {
                $acceleration >= 86 => 1,
                $acceleration >= 83 => 2,
                $acceleration >= 80 => 3,
                $acceleration < 80 => 9,
            };
            $event->getGauntlet()->setAcceleration($score);
            // Score Handling
            $score = match (true) {
                $handling >= 80 => 1,
                $handling >= 60 => 2,
                $handling >= 40 => 3,
                $handling < 40 => 9,
            };
            $event->getGauntlet()->setHandling($score);
            // Score Nitro
            $score = match (true) {
                $nitro >= 75 => 1,
                $nitro >= 60 => 2,
                $nitro >= 45 => 3,
                $nitro < 45 => 9,
            };
            $event->getGauntlet()->setNitro($score);
        }
    }
}
