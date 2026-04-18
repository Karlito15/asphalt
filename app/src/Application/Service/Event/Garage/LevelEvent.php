<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Garage;

use App\Application\Event\Garage\AppUpdateLevelEvent;

final class LevelEvent
{
    /**
     * Met à jour automatiquement la colonne Level dans Garage.
     *
     * @param AppUpdateLevelEvent $event
     * @return void
     */
    public static function updateGarageLevel(AppUpdateLevelEvent $event): void
    {
        ### Variables
        $garage = $event->getGarage();
        $stars  = $event->getStars();
        $status = $garage->getStatusControl();

        ### Conditions
        switch ($stars) :
            case 3:
                if ($status->isFullStar3()):
                    $garage->setLevel(10);
                endif;
                if ($status->isFullStar2() && $status->isFullStar3() === false):
                    $garage->setLevel(8);
                endif;
                if ($status->isFullStar1() && $status->isFullStar2() === false):
                    $garage->setLevel(5);
                endif;
                break;
            case 4:
                if ($status->isFullStar4()):
                    $garage->setLevel(11);
                endif;
                if ($status->isFullStar3() && $status->isFullStar4() === false):
                    $garage->setLevel(9);
                endif;
                if ($status->isFullStar2() && $status->isFullStar3() === false):
                    $garage->setLevel(7);
                endif;
                if ($status->isFullStar1() && $status->isFullStar2() === false):
                    $garage->setLevel(4);
                endif;
                break;
            case (5 or 6):
                if ($status->isFullStar6()):
                    $garage->setLevel(13);
                endif;
                if ($status->isFullStar5() && $status->isFullStar6() === false):
                    $garage->setLevel(12);
                endif;
                if ($status->isFullStar4() && $status->isFullStar5() === false):
                    $garage->setLevel(10);
                endif;
                if ($status->isFullStar3() && $status->isFullStar4() === false):
                    $garage->setLevel(8);
                endif;
                if ($status->isFullStar2() && $status->isFullStar3() === false):
                    $garage->setLevel(6);
                endif;
                if ($status->isFullStar1() && $status->isFullStar2() === false):
                    $garage->setLevel(3);
                endif;
                break;
        endswitch;
    }
}
