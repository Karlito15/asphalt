<?php

declare(strict_types=1);

namespace App\Service\Event\Garage;

use App\Event\Garage\BlueprintEvent;
use App\Event\Garage\GarageEvent;
use App\Event\Garage\StatMaxEvent;
use App\Event\Garage\UpgradeEvent;

class StatusControlService
{
    public static function FullBlueprints(BlueprintEvent $event): void
    {
        // Get Blueprints
        $garage  = $event->getGarageStars();
        $setting = $event->getSettingStars();

        // Stars of Garage
        $stars   = $event->getGarage()->getStars();

        switch ($stars):
            case 6:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                endif;
                if ($garage['star5'] === $setting['star5']):
                    $event->getGarage()->getStatusControl()->setFullStar5(true);
                endif;
                if ($garage['star6'] === $setting['star6']):
                    $event->getGarage()->getStatusControl()->setFullStar6(true);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                endif;
                break;
            case 5:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                endif;
                if ($garage['star5'] === $setting['star5']):
                    $event->getGarage()->getStatusControl()->setFullStar5(true);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
                endif;
                break;
            case 4:
                if ($garage['star1'] === $setting['star1']):
                    $event->getGarage()->getStatusControl()->setFullStar1(true);
                endif;
                if ($garage['star2'] === $setting['star2']):
                    $event->getGarage()->getStatusControl()->setFullStar2(true);
                endif;
                if ($garage['star3'] === $setting['star3']):
                    $event->getGarage()->getStatusControl()->setFullStar3(true);
                endif;
                if ($garage['star4'] === $setting['star4']):
                    $event->getGarage()->getStatusControl()->setFullStar4(true);
                endif;
                if ($garage['total'] === $setting['total']):
                    $event->getGarage()->getStatusControl()->setFullBlueprint(true);
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
     * Détermine si toutes les upgrades sont installées
     *
     * @param UpgradeEvent $event
     * @param string $category
     * @return void
     */
    public static function FullUpgrade(UpgradeEvent $event, string $category): void
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
        if ($upgrades === $setting['level']) {
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setFullSpeed(true),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(true),
                'handling'     => $event->getGarage()->getStatusControl()->setFullHandling(true),
                'nitro'        => $event->getGarage()->getStatusControl()->setFullNitro(true),
            };
        } else {
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setFullSpeed(false),
                'acceleration' => $event->getGarage()->getStatusControl()->setFullAcceleration(false),
                'handling'     => $event->getGarage()->getStatusControl()->setFullHandling(false),
                'nitro'        => $event->getGarage()->getStatusControl()->setFullNitro(false),
            };
        }

        // Compare l'ensemble des catégories
        if (
            $garage['speed'] === $setting['level'] &&
            $garage['acceleration'] === $setting['level'] &&
            $garage['handling'] === $setting['level'] &&
            $garage['nitro'] === $setting['level']
        ) {
            $event->getGarage()->getStatusControl()->setFullUpgrade(true);
        } else {
            $event->getGarage()->getStatusControl()->setFullUpgrade(false);
        }
    }

    /**
     * Détermine si tous les imports sont installés
     *
     * @param UpgradeEvent $event
     * @param string $category
     * @return void
     */
    public static function FullImport(UpgradeEvent $event, string $category): void
    {
        // Get Upgrades
        $garage  = $event->getGarageUpgrade();
        $setting = $event->getSettingUpgrade();

        $imports = match ($category) {
            'common'       => $garage['common'],
            'rare'         => $garage['rare'],
            'epic'         => $garage['epic'],
        };

        // Compare chaque catégorie
        if ($imports === $setting[$category]) {
            match ($category) {
                'common'       => $event->getGarage()->getStatusControl()->setFullCommon(true),
                'rare'         => $event->getGarage()->getStatusControl()->setFullRare(true),
                'epic'         => $event->getGarage()->getStatusControl()->setFullEpic(true),
            };
        } else {
            match ($category) {
                'common'       => $event->getGarage()->getStatusControl()->setFullCommon(false),
                'rare'         => $event->getGarage()->getStatusControl()->setFullRare(false),
                'epic'         => $event->getGarage()->getStatusControl()->setFullEpic(false),
            };
        }

        // Compare l'ensemble des catégories
        if (
            $garage['common'] === $setting['common'] &&
            $garage['rare'] === $setting['rare'] &&
            $garage['epic'] === $setting['epic']
        ) {
            $event->getGarage()->getStatusControl()->setFullImport(true);
        } else {
            $event->getGarage()->getStatusControl()->setFullImport(false);
        }
    }

    /**
     * Détermine si toutes des upgrades doivent être installées
     *
     * @param UpgradeEvent $event
     * @param string $category
     * @return void
     */
    public static function InstallUpgrade(UpgradeEvent $event, string $category): void
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
        if ($upgrades < $setting['level']) {
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setToInstallSpeed(true),
                'acceleration' => $event->getGarage()->getStatusControl()->setToInstallAcceleration(true),
                'handling'     => $event->getGarage()->getStatusControl()->setToInstallHandling(true),
                'nitro'        => $event->getGarage()->getStatusControl()->setToInstallNitro(true),
            };
        } else {
            match ($category) {
                'speed'        => $event->getGarage()->getStatusControl()->setToInstallSpeed(false),
                'acceleration' => $event->getGarage()->getStatusControl()->setToInstallAcceleration(false),
                'handling'     => $event->getGarage()->getStatusControl()->setToInstallHandling(false),
                'nitro'        => $event->getGarage()->getStatusControl()->setToInstallNitro(false),
            };
        }
    }

    /**
     * @param GarageEvent $event
     * @return void
     */
    public static function toGold(GarageEvent $event): void
    {
        // Already Gold
        if ($event->getGarage()->getStatus()->isGold()) {
            $event->getGarage()->getStatusControl()->setToGold(false);
        } else {
            // Condition to Gold
            if (
                // Toutes les blueprints
                $event->getGarage()->getStatusControl()->isFullBlueprint() &&
                // On a tte les cartes Epic pour la voiture
                ($event->getGarage()->getEpic() === $event->getGarage()->getSettingLevel()->getEpic())
            ) {
                $event->getGarage()->getStatusControl()->setToGold(true);
            } else {
                $event->getGarage()->getStatusControl()->setToGold(false);
            }
        }
    }

    public static function toUnblock(StatMaxEvent $event): void
    {
        if ($event->getAverage() >= $event->getGarage()->getSettingClass()->getMedian()) {
            $event->getGarage()->getStatusControl()->setToUnblock(true);
        } else {
            $event->getGarage()->getStatusControl()->setToUnblock(false);
        }
    }
}
