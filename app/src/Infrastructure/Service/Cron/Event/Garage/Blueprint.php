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
        $status  = $event->getGarage()->getStatus();
        $control = $event->getGarage()->getStatusControl();

        ### Conditions
        if ($event->getBlueprintFirstStar() === $event->getSettingFirstStar()):
            $status->setUnblock(true);
            $control->setFullStar1(true);
        else:
            $status->setUnblock(false);
            $control->setFullStar1(false);
        endif;
    }

    /**
     * Vérifie si le nombre de cartes pour la deuxième étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullStar2(AppEvent $event): void
    {
        ### Variables
        $control    = $event->getGarage()->getStatusControl();
        $blueprints = $event->getBlueprintAllStars();
        $settings   = $event->getSettingAllStars();

        ### Conditions
        if ($blueprints['star2'] === $settings['star2']):
            $control->setFullStar2(true);
        else:
            $control->setFullStar2(false);
        endif;
    }

    /**
     * Vérifie si le nombre de cartes pour la troisième étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullStar3(AppEvent $event): void
    {
        ### Variables
        $control    = $event->getGarage()->getStatusControl();
        $blueprints = $event->getBlueprintAllStars();
        $settings   = $event->getSettingAllStars();

        ### Conditions
        if ($blueprints['star3'] === $settings['star3']):
            $control->setFullStar3(true);
        else:
            $control->setFullStar3(false);
        endif;
    }

    /**
     * Vérifie si le nombre de cartes pour la quatrième étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullStar4(AppEvent $event): void
    {
        if($event->getStars() > 3) {
            ### Variables
            $control    = $event->getGarage()->getStatusControl();
            $blueprints = $event->getBlueprintAllStars();
            $settings   = $event->getSettingAllStars();

            ### Conditions
            if ($blueprints['star4'] === $settings['star4']):
                $control->setFullStar4(true);
            else:
                $control->setFullStar4(false);
            endif;
        }
    }

    /**
     * Vérifie si le nombre de cartes pour la cinquième étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullStar5(AppEvent $event): void
    {
        if($event->getStars() > 3) {
            ### Variables
            $control    = $event->getGarage()->getStatusControl();
            $blueprints = $event->getBlueprintAllStars();
            $settings   = $event->getSettingAllStars();

            ### Conditions
            if ($blueprints['star5'] === $settings['star5']):
                $control->setFullStar5(true);
            else:
                $control->setFullStar5(false);
            endif;
        }
    }

    /**
     * Vérifie si le nombre de cartes pour la sixième étoile est atteint
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullStar6(AppEvent $event): void
    {
        if($event->getStars() > 3) {
            ### Variables
            $control    = $event->getGarage()->getStatusControl();
            $blueprints = $event->getBlueprintAllStars();
            $settings   = $event->getSettingAllStars();

            ### Conditions
            if ($blueprints['star6'] === $settings['star6']):
                $control->setFullStar6(true);
            else:
                $control->setFullStar6(false);
            endif;
        }
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
        $control    = $event->getGarage()->getStatusControl();
        $blueprints = $event->getBlueprintAllStars();
        $settings   = $event->getSettingAllStars();

        ### Conditions
        if ($blueprints['total'] === $settings['total']):
            $control->setFullBlueprint(true);
        else:
            $control->setFullBlueprint(false);
        endif;
    }
}
