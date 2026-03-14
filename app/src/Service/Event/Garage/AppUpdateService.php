<?php

declare(strict_types=1);

namespace App\Service\Event\Garage;

use App\Event\Garage\AppUpdateEvent;

class AppUpdateService
{
    /**
     * Met à jour automatiquement la colonne Level dans Garage.
     * Fonctionne avec les voitures 4, 5, 6 étoiles
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function GarageLevel(AppUpdateEvent $event): void
    {
        ### Variables
        $garage = $event->getGarage();
        $stars  = $garage->getStars();
        $status = $garage->getStatusControl();

        ### Conditions
        switch ($stars) :
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

    /**
     * Détermine si la voiture est débloquée
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusUnblock(AppUpdateEvent $event): void
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
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusGold(AppUpdateEvent $event): void
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

    /**
     * Détermine si la voiture a toutes les cartes
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlBlueprint(AppUpdateEvent $event): void
    {
        ### Variables
        // Get Blueprints
        $garage  = $event->getGarageStars();
        $setting = $event->getSettingStars();

        // Stars of Garage
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
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlEvo(AppUpdateEvent $event): void
    {
        ### Variables
        $garage = $event->getGarage();

        ### Conditions
        if ($garage->getStatus()->isEvo() && ($garage->getEvo() === 24)):
            $garage->getStatusControl()->setFullEvo(true);
        else:
            $garage->getStatusControl()->setFullEvo(false);
        endif;
    }

    /**
     * Mets à jour automatiquement la table Garage Gauntlet en fonction des valeurs stats max
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlGauntlet(AppUpdateEvent $event): void
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

    /**
     * Détermine si tous les imports sont installés
     *
     * @param AppUpdateEvent $event
     * @param string $category
     * @return void
     */
    public static function StatusControlImport(AppUpdateEvent $event, string $category): void
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
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlToGold(AppUpdateEvent $event): void
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
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlToInstallImports(AppUpdateEvent $event): void
    {
        ### Common
        if ($event->getLevel() > 2):
            $event->getGarage()->getStatusControl()->setToInstallCommon(true);
//            $event->getGarage()->getStatusControl()->setToInstallImport(true);
        elseif ($event->getGarageUpgrade()['common'] === $event->getSettingUpgrade()['common']):
            $event->getGarage()->getStatusControl()->setToInstallCommon(false);
//            $event->getGarage()->getStatusControl()->setToInstallImport(false);
        else:
            $event->getGarage()->getStatusControl()->setToInstallCommon(false);
//            $event->getGarage()->getStatusControl()->setToInstallImport(false);
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
     * @param AppUpdateEvent $event
     * @param string $category
     * @return void
     */
    public static function StatusControlToInstallUpgrades(AppUpdateEvent $event, string $category): void
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
     * Détermine si la voiture doit être débloquée
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function StatusControlToUnblock(AppUpdateEvent $event): void
    {
        ### Conditions
        if ($event->getAverage() >= $event->getGarage()->getSettingClass()->getMedian()):
            $event->getGarage()->getStatusControl()->setToUnblock(true);
        else:
            $event->getGarage()->getStatusControl()->setToUnblock(false);
        endif;
    }

    /**
     * Détermine si toutes les upgrades sont installées
     *
     * @param AppUpdateEvent $event
     * @param string $category
     * @return void
     */
    public static function StatusControlUpgrade(AppUpdateEvent $event, string $category): void
    {
        // Get Upgrades
        $garage  = $event->getGarageUpgrade();
        $setting = $event->getSettingUpgrade();

        $upgrades = match ($category) {
            'speed' => $garage['speed'],
            'acceleration' => $garage['acceleration'],
            'handling' => $garage['handling'],
            'nitro' => $garage['nitro'],
        };

        // Compare chaque catégorie
        if ($upgrades === $setting['level']):
            match ($category) {
                'speed' => $event->getGarage()->getStatusControl()->setFullSpeed(true),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(true),
                'handling' => $event->getGarage()->getStatusControl()->setFullHandling(true),
                'nitro' => $event->getGarage()->getStatusControl()->setFullNitro(true),
            };
        else:
            match ($category) {
                'speed' => $event->getGarage()->getStatusControl()->setFullSpeed(false),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(false),
                'handling' => $event->getGarage()->getStatusControl()->setFullHandling(false),
                'nitro' => $event->getGarage()->getStatusControl()->setFullNitro(false),
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

    /**
     * Si la voiture est Gold, alors on copie les stats max vers les stats actuelles
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public static function copyStatMaxToStatActual(AppUpdateEvent $event): void
    {
        ### Variables
        $garage     = $event->getGarage();
        $statActual = $garage->getStatActual();
        $statMax    = $garage->getStatMax();
        $status     = $garage->getStatus();

        ### Conditions
        if ($status->isGold() === true):
            $statActual->setSpeed($statMax->getSpeed());
            $statActual->setAcceleration($statMax->getAcceleration());
            $statActual->setHandling($statMax->getHandling());
            $statActual->setNitro($statMax->getNitro());
            $statActual->setAverage($statMax->getSpeed(), $statMax->getAcceleration(), $statMax->getHandling(), $statMax->getNitro());
        endif;
    }

    /** NO USAGES */

    /** PRIVATE METHODS */
}
