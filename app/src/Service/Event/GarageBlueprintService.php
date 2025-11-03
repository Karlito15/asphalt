<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Entity\GarageBlueprint;
use App\Entity\GarageStatus;
use App\Entity\SettingBlueprint;
use App\Event\Garage\UpdateEvent;

class GarageBlueprintService
{
    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar1(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar1() === $blueprint->getStar1()) {
                $status->setFullBlueprintStar1(true);
            } else {
                $status->setFullBlueprintStar1(false);
            }
        }
    }

    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar2(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar2() === $blueprint->getStar2()) {
                $status->setFullBlueprintStar2(true);
            } else {
                $status->setFullBlueprintStar2(false);
            }
        }
    }

    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar3(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar3() === $blueprint->getStar3()) {
                $status->setFullBlueprintStar3(true);
            } else {
                $status->setFullBlueprintStar3(false);
            }
        }
    }

    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar4(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar4() === $blueprint->getStar4()) {
                $status->setFullBlueprintStar4(true);
            } else {
                $status->setFullBlueprintStar4(false);
            }
        }
    }

    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar5(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar5() === $blueprint->getStar5()) {
                $status->setFullBlueprintStar5(true);
            } else {
                $status->setFullBlueprintStar5(false);
            }
        }
    }

    /**
     * Détermine si tous les blueprints sont achetés pour un niveau donnée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isFullBlueprintStar6(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $blueprint  = self::blueprint($event);
        $status     = self::status($event);
        $setting    = self::setting($event);

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($setting->getStar6() === $blueprint->getStar6()) {
                $status->setFullBlueprintStar6(true);
            } else {
                $status->setFullBlueprintStar6(false);
            }

            if ($setting->getStar6() === $blueprint->getStar6()) {
                if ($status->isFullBlueprintStar1() === true) {
                    $status->setFullUpgradeLevel(true);
                }
            }
        }
    }

    private static function blueprint(UpdateEvent $event): GarageBlueprint
    {
        return $event->getBlueprint();
    }

    private static function setting(UpdateEvent $event): SettingBlueprint
    {
        return $event->getSettingBlueprint();
    }

    private static function status(UpdateEvent $event): GarageStatus
    {
        return $event->garage->getStatus()->getValues()[0];
    }
}
