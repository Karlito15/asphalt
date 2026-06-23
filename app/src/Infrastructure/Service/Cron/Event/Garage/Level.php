<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Level
{
    /**
     * Met à jour automatiquement le Level de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    public static function getLevel(AppEvent $event): void
    {

        ### Variables
        $garage = $event->getGarage();
        $stars  = $event->getStars();
        $entity = $garage->getStatusControl();

        ### Conditions
        switch ($stars) :
            case 3:
                if ($entity->isFullStar3()):
                    $garage->setLevel(10);
                endif;
                if ($entity->isFullStar2() && $entity->isFullStar3() === false):
                    $garage->setLevel(8);
                endif;
                if ($entity->isFullStar1() && $entity->isFullStar2() === false):
                    $garage->setLevel(5);
                endif;
                break;
            case 4:
                if ($entity->isFullStar4()):
                    $garage->setLevel(11);
                endif;
                if ($entity->isFullStar3() && $entity->isFullStar4() === false):
                    $garage->setLevel(9);
                endif;
                if ($entity->isFullStar2() && $entity->isFullStar3() === false):
                    $garage->setLevel(7);
                endif;
                if ($entity->isFullStar1() && $entity->isFullStar2() === false):
                    $garage->setLevel(4);
                endif;
                break;
            case (5 or 6):
                if ($entity->isFullStar6()):
                    $garage->setLevel(13);
                endif;
                if ($entity->isFullStar5() && $entity->isFullStar6() === false):
                    $garage->setLevel(12);
                endif;
                if ($entity->isFullStar4() && $entity->isFullStar5() === false):
                    $garage->setLevel(10);
                endif;
                if ($entity->isFullStar3() && $entity->isFullStar4() === false):
                    $garage->setLevel(8);
                endif;
                if ($entity->isFullStar2() && $entity->isFullStar3() === false):
                    $garage->setLevel(6);
                endif;
                if ($entity->isFullStar1() && $entity->isFullStar2() === false):
                    $garage->setLevel(3);
                endif;
                break;
        endswitch;
    }
}
