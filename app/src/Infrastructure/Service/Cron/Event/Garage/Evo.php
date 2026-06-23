<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Evo
{
    /**
     * Vérifie si le nombre d'évolutions sont installés
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlEvo(AppEvent $event): void
    {
        ### Variables
        $garage = $event->getGarage();

        ### Conditions
        if ($garage->getStatus()->isEvo()) :
            if ($garage->getEvo() === 24):
                $garage->getStatusControl()->setFullEvo(true);
            else:
                $garage->getStatusControl()->setFullEvo(false);
            endif;
        endif;
    }
}
