<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Blueprint
{
    /**
     * Vérifie si le nombre de cartes pour la première étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusUnblock(AppEvent $event): void
    {
        ### Variables
        $status = $event->getGarage()->getStatus();

        ### Conditions
        if ($event->getBlueprintFirstStar() === $event->getSettingFirstStar()):
            $status->setUnblock(true);
        else:
            $status->setUnblock(false);
        endif;
    }

    /**
     * Vérifie pour chaque étoile si le nombre de cartes nécessaires est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlBlueprint(AppEvent $event): void
    {
        ### Variables
        $star       = $event->getStars();
        $blueprint  = $event->getBlueprintAllStars();
        $setting    = $event->getSettingAllStars();
        $control    = $event->getGarage()->getStatusControl();

        ### Conditions

        ### Star 1
        if ($blueprint['star1'] === $setting['star1']):
            $control->setFullStar1(true);
        else:
            $control->setFullStar1(false);
        endif;

        ### Star 2
        if ($blueprint['star2'] === $setting['star2']):
            $control->setFullStar2(true);
        else:
            $control->setFullStar2(false);
        endif;

        ### Star 3
        if ($blueprint['star3'] === $setting['star3']):
            $control->setFullStar3(true);
        else:
            $control->setFullStar3(false);
        endif;

        switch ($star):
            case 6:
                ### Star 4
                if ($blueprint['star4'] === $setting['star4']):
                    $control->setFullStar4(true);
                else:
                    $control->setFullStar4(false);
                endif;

                ### Star 5
                if ($blueprint['star5'] === $setting['star5']):
                    $control->setFullStar5(true);
                else:
                    $control->setFullStar5(false);
                endif;

                ### Star 6
                if ($blueprint['star6'] === $setting['star6']):
                    $control->setFullStar6(true);
                else:
                    $control->setFullStar6(false);
                endif;
                break;
            case 5:
                if ($blueprint['star4'] === $setting['star4']):
                    $control->setFullStar4(true);
                else:
                    $control->setFullStar4(false);
                endif;
                if ($blueprint['star5'] === $setting['star5']):
                    $control->setFullStar5(true);
                else:
                    $control->setFullStar5(false);
                endif;
                break;
            case 4:
                if ($blueprint['star4'] === $setting['star4']):
                    $control->setFullStar4(true);
                else:
                    $control->setFullStar4(false);
                endif;
                break;
        endswitch;
    }

    /**
     * Vérifie si le nombre total de cartes est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullBlueprint(AppEvent $event): void
    {
        ### Variables
        $star       = $event->getStars();
        $control    = $event->getGarage()->getStatusControl();

        ### Conditions
        switch ($star):
            case 6:
                if (
                    ($control->isFullStar1() === true) AND
                    ($control->isFullStar2() === true) AND
                    ($control->isFullStar3() === true) AND
                    ($control->isFullStar4() === true) AND
                    ($control->isFullStar5() === true) AND
                    ($control->isFullStar6() === true)
                ):
                    $control->setFullBlueprint(true);
                else :
                    $control->setFullBlueprint(false);
                endif;
                break;
            case 5:
                if (
                    ($control->isFullStar1() === true) AND
                    ($control->isFullStar2() === true) AND
                    ($control->isFullStar3() === true) AND
                    ($control->isFullStar4() === true) AND
                    ($control->isFullStar5() === true)
                ):
                    $control->setFullBlueprint(true);
                else :
                    $control->setFullBlueprint(false);
                endif;
                break;
            case 4:
                if (
                    ($control->isFullStar1() === true) AND
                    ($control->isFullStar2() === true) AND
                    ($control->isFullStar3() === true) AND
                    ($control->isFullStar4() === true)
                ):
                    $control->setFullBlueprint(true);
                else :
                    $control->setFullBlueprint(false);
                endif;
                break;
            case 3:
                if (
                    ($control->isFullStar1() === true) AND
                    ($control->isFullStar2() === true) AND
                    ($control->isFullStar3() === true)
                ):
                    $control->setFullBlueprint(true);
                else :
                    $control->setFullBlueprint(false);
                endif;
                break;
        endswitch;
    }
}
