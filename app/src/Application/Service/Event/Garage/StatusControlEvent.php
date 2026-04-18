<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Garage;

use App\Application\Event\Garage\AppUpdateStatusControlEvent;

final class StatusControlEvent
{
    /**
     * Détermine si la voiture a toutes les cartes
     *
     * @param AppUpdateStatusControlEvent $event
     * @return void
     */
    public static function updateGarageStatusControlBlueprint(AppUpdateStatusControlEvent $event): void
    {
        ### Variables
        $garage  = $event->getGarageStars();
        $setting = $event->getSettingStars();
        $stars   = $event->getGarage()->getStars();

        ### Conditions
        switch ($stars):
            case 6:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar1(false);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar2(false);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar3(false);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar4(false);
                endif;
                if ($garage['star5'] === $setting['star5']):
                    $event->getGarage()->getStatusControl()->setFullStar5(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar5(false);
                endif;
                if ($garage['star6'] === $setting['star6']):
                    $event->getGarage()->getStatusControl()->setFullStar6(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar6(false);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullBlueprint(false);
                endif;
                break;
            case 5:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar1(false);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar2(false);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar3(false);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar4(false);
                endif;
                if ($garage['star5'] === $setting['star5']):
                    $event->getGarage()->getStatusControl()->setFullStar5(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar5(false);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullBlueprint(false);
                endif;
                break;
            case 4:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar1(false);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar2(false);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar3(false);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullStar4(false);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                else:
                    $event->getGarage()->getStatusControl()->setFullBlueprint(false);
                endif;
                break;
            case 3:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                endif;
                break;
        endswitch;
    }

    /**
     * Détermine si la voiture possède toutes les cartes EVO
     *
     * @param AppUpdateStatusControlEvent $event
     * @return void
     */
    public static function updateGarageStatusControlEvo(AppUpdateStatusControlEvent $event): void
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

    /**
     * Détermine si tous les imports sont installés
     *
     * @param AppUpdateStatusControlEvent $event
     * @param string $category
     * @return void
     */
    public static function updateGarageStatusControlImport(AppUpdateStatusControlEvent $event, string $category): void
    {
        // Get Upgrades
        $garage  = $event->getGarageUpgrade();
        $setting = $event->getSettingUpgrade();

        $imports = match ($category) {
            'common' => $garage['common'],
            'rare' => $garage['rare'],
            'epic' => $garage['epic'],
        };

        // Compare chaque catégorie
        if ($imports === $setting[$category]):
            match ($category) {
                'common' => $event->getGarage()->getStatusControl()->setFullCommon(true),
                'rare' => $event->getGarage()->getStatusControl()->setFullRare(true),
                'epic' => $event->getGarage()->getStatusControl()->setFullEpic(true),
            };
        else:
            match ($category) {
                'common' => $event->getGarage()->getStatusControl()->setFullCommon(false),
                'rare' => $event->getGarage()->getStatusControl()->setFullRare(false),
                'epic' => $event->getGarage()->getStatusControl()->setFullEpic(false),
            };
        endif;

        // Compare l'ensemble des catégories
        if (
            $garage['common'] === $setting['common'] &&
            $garage['rare'] === $setting['rare'] &&
            $garage['epic'] === $setting['epic']
        ):
            $event->getGarage()->getStatusControl()->setFullImport(true);
        else:
            $event->getGarage()->getStatusControl()->setFullImport(false);
        endif;
    }

    /**
     * Détermine si tous les imports & les upgrades de la voiture sont prêts à être installés
     *
     * @param AppUpdateStatusControlEvent $event
     * @return void
     */
    public static function updateGarageStatusControlToGold(AppUpdateStatusControlEvent $event): void
    {
        // Already Gold
        if ($event->getGarage()->getStatus()->isGold()):
            $event->getGarage()->getStatusControl()->setToGold(false);
        else:
            // Condition to Gold
            if (
                // Toutes les blueprints
                $event->getGarage()->getStatusControl()->isFullBlueprint() &&
                // On a tte les cartes Epic pour la voiture
                ($event->getGarage()->getEpic() === $event->getGarage()->getSettingLevel()->getEpic())
            ):
                $event->getGarage()->getStatusControl()->setToGold(true);
            else:
                $event->getGarage()->getStatusControl()->setToGold(false);
            endif;
        endif;
    }

    /**
     * @param AppUpdateStatusControlEvent $event
     * @return void
     */
    public static function updateGarageStatusControlToInstallImports(AppUpdateStatusControlEvent $event): void
    {
        ### Common
        if ($event->getLevel() > 2):
            $event->getGarage()->getStatusControl()->setToInstallCommon(true);
            //$event->getGarage()->getStatusControl()->setToInstallImport(true);
        elseif ($event->getGarageUpgrade()['common'] === $event->getSettingUpgrade()['common']):
            $event->getGarage()->getStatusControl()->setToInstallCommon(false);
            //$event->getGarage()->getStatusControl()->setToInstallImport(false);
        else:
            $event->getGarage()->getStatusControl()->setToInstallCommon(false);
            //$event->getGarage()->getStatusControl()->setToInstallImport(false);
        endif;

        ### Rare
        if ($event->getLevel() > 5 && ($event->getGarageUpgrade()['rare'] < $event->getSettingUpgrade()['rare'])):
            $event->getGarage()->getStatusControl()->setToInstallRare(true);
        elseif ($event->getGarageUpgrade()['rare'] === $event->getSettingUpgrade()['rare']):
            $event->getGarage()->getStatusControl()->setToInstallRare(false);
        else:
            $event->getGarage()->getStatusControl()->setToInstallRare(false);
        endif;

        ### Epic
        if ($event->getGarageUpgrade()['epic'] > 0 && ($event->getGarageUpgrade()['epic'] < $event->getSettingUpgrade()['epic'])):
            $event->getGarage()->getStatusControl()->setToInstallEpic(true);
        elseif ($event->getGarageUpgrade()['epic'] === $event->getSettingUpgrade()['epic']):
            $event->getGarage()->getStatusControl()->setToInstallEpic(false);
        else:
            $event->getGarage()->getStatusControl()->setToInstallEpic(false);
        endif;
    }

    /**
     * Détermine des upgrades peuvent être installées
     *
     * @param AppUpdateStatusControlEvent $event
     * @param string $category
     * @return void
     */
    public static function updateGarageStatusControlToInstallUpgrades(AppUpdateStatusControlEvent $event, string $category): void
    {
        // Get Upgrades
        $garage = $event->getGarageUpgrade();

        $upgrades = match ($category) {
            'speed'        => $garage['speed'],
            'acceleration' => $garage['acceleration'],
            'handling'     => $garage['handling'],
            'nitro'        => $garage['nitro'],
        };

        // Compare chaque catégorie
        if ($upgrades < $event->getLevel()):
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setToInstallSpeed(true),
                'acceleration' => $event->getGarage()->getStatusControl()->setToInstallAcceleration(true),
                'handling'     => $event->getGarage()->getStatusControl()->setToInstallHandling(true),
                'nitro'        => $event->getGarage()->getStatusControl()->setToInstallNitro(true),
            };
        else:
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setToInstallSpeed(false),
                'acceleration' => $event->getGarage()->getStatusControl()->setToInstallAcceleration(false),
                'handling'     => $event->getGarage()->getStatusControl()->setToInstallHandling(false),
                'nitro'        => $event->getGarage()->getStatusControl()->setToInstallNitro(false),
            };
        endif;
    }

    /**
     * Détermine si toutes les upgrades sont installées
     *
     * @param AppUpdateStatusControlEvent $event
     * @param string $category
     * @return void
     */
    public static function updateGarageStatusControlUpgrade(AppUpdateStatusControlEvent $event, string $category): void
    {
        // Get Upgrades
        $garage  = $event->getGarageUpgrade();
        $setting = $event->getSettingUpgrade();

        $upgrades = match ($category) {
            'speed'        => $garage['speed'],
            'acceleration' => $garage['acceleration'],
            'handling'     => $garage['handling'],
            'nitro'        => $garage['nitro'],
        };

        // Compare chaque catégorie
        if ($upgrades === $setting['level']):
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setFullSpeed(true),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(true),
                'handling'     => $event->getGarage()->getStatusControl()->setFullHandling(true),
                'nitro'        => $event->getGarage()->getStatusControl()->setFullNitro(true),
            };
        else:
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setFullSpeed(false),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(false),
                'handling'     => $event->getGarage()->getStatusControl()->setFullHandling(false),
                'nitro'        => $event->getGarage()->getStatusControl()->setFullNitro(false),
            };
        endif;

        // Compare l'ensemble des catégories
        if (
            $garage['speed'] === $setting['level'] &&
            $garage['acceleration'] === $setting['level'] &&
            $garage['handling'] === $setting['level'] &&
            $garage['nitro'] === $setting['level']
        ):
            $event->getGarage()->getStatusControl()->setFullUpgrade(true);
        else:
            $event->getGarage()->getStatusControl()->setFullUpgrade(false);
        endif;
    }
}
