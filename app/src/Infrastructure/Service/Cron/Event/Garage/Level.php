<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Level
{
    /**
     * Vérifie si tous les blueprints sont completés niveau par niveau
     * Met à jour automatiquement le Level de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    public static function getLevel(AppEvent $event): void
    {
        ### Variables
        $garage     = $event->getGarage();
        $stars      = $event->getStars();
        $blueprints = $event->getBlueprintAllStars();
        $settings   = $event->getSettingAllStars();

        ### Conditions
        switch ($stars) :
            case 3:
                if ($blueprints['star3'] === $settings['star3']):
                     $garage->setLevel(10);
                endif;
                if ($blueprints['star2'] === $settings['star2'] && $blueprints['star3'] !== $settings['star3']):
                     $garage->setLevel(8);
                endif;
                if ($blueprints['star1'] === $settings['star1'] && $blueprints['star2'] !== $settings['star2']):
                     $garage->setLevel(5);
                endif;
            break;
            case 4:
                if ($blueprints['star4'] === $settings['star4']):
                     $garage->setLevel(11);
                endif;
                if ($blueprints['star3'] === $settings['star3'] && $blueprints['star4'] !== $settings['star4']):
                     $garage->setLevel(9);
                endif;
                if ($blueprints['star2'] === $settings['star2'] && $blueprints['star3'] !== $settings['star3']):
                     $garage->setLevel(7);
                endif;
                if ($blueprints['star1'] === $settings['star1'] && $blueprints['star2'] !== $settings['star2']):
                     $garage->setLevel(4);
                endif;
            break;
            case 5:
                if ($blueprints['star5'] === $settings['star5']):
                     $garage->setLevel(12);
                endif;
                self::setLevel10($garage, $blueprints, $settings);
                self::setLevel8($garage, $blueprints, $settings);
                self::setLevel6($garage, $blueprints, $settings);
                self::setLevel3($garage, $blueprints, $settings);
            break;
            case 6:
                if ($blueprints['star6'] === $settings['star6']):
                     $garage->setLevel(13);
                endif;
                if ($blueprints['star5'] === $settings['star5'] && $blueprints['star6'] !== $settings['star6']):
                     $garage->setLevel(12);
                endif;
                self::setLevel10($garage, $blueprints, $settings);
                self::setLevel8($garage, $blueprints, $settings);
                self::setLevel6($garage, $blueprints, $settings);
                self::setLevel3($garage, $blueprints, $settings);
            break;
        endswitch;
    }

    /** PRIVATE METHODS */

    private static function setLevel10(GarageApp $garage, array $blueprints, array $settings): void
    {
        if ($blueprints['star4'] === $settings['star4'] && $blueprints['star5'] !== $settings['star5']):
             $garage->setLevel(10);
        endif;
    }

    private static function setLevel8(GarageApp $garage, array $blueprints, array $settings): void
    {
        if ($blueprints['star3'] === $settings['star3'] && $blueprints['star4'] !== $settings['star4']):
             $garage->setLevel(8);
        endif;
    }

    private static function setLevel6(GarageApp $garage, array $blueprints, array $settings): void
    {
        if ($blueprints['star2'] === $settings['star2'] && $blueprints['star3'] !== $settings['star3']):
             $garage->setLevel(6);
        endif;
    }

    private static function setLevel3(GarageApp $garage, array $blueprints, array $settings): void
    {
        if ($blueprints['star1'] === $settings['star1'] && $blueprints['star2'] !== $settings['star2']):
             $garage->setLevel(3);
        endif;
    }
}
