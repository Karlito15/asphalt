<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Garage;

use App\Infrastructure\Event\Garage\AppEvent;

final readonly class Upgrade
{
    /**
     * Vérifie si toutes les conditions sont remplies pour installer toutes les évolutions de la voiture
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusToGold(AppEvent $event): void
    {
        ### Variables
        $epic     = $event->getEpic();
        $settings = $event->getSettingUpgrades();
        $entity   = $event->getGarage()->getStatusControl();

        ### Conditions
        if ($entity->isFullBlueprint()):
            if ($epic === $settings["epic"]):
                $entity->setToGold(true);
            endif;
        else:
            $entity->setToGold(false);
        endif;

        ### Already Gold
        if ($event->getGarage()->getStatus()->isGold()):
            $entity->setToGold(false);
        endif;
    }

    /**
     * Vérifie si toutes les conditions sont remplies pour la voiture Gold
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusGold(AppEvent $event): void
    {
        ### Variables
        $status  = $event->getGarage()->getStatus();
        $control = $event->getGarage()->getStatusControl();

        ### Conditions
        if ($control->isFullBlueprint() && $control->isFullUpgrade() && $control->isFullImport()):
            $status->setGold(true);
        else:
            $status->setGold(false);
        endif;
    }

    /**
     * XXXX
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlUpgrade(AppEvent $event): void
    {
        ### Variables
        $level   = $event->getLevel();
        $epic    = $event->getEpic();
        $upgrade = $event->getUpgrade();
        $setting = $event->getSettingUpgrades();
        $entity  = $event->getGarage()->getStatusControl();

        ### Conditions
        ###### Speed
        if (($upgrade["speed"] < $level)) :
            $entity
                ->setToInstallSpeed(true)
                ->setToInstallUpgrade(true)
                ->setFullSpeed(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["speed"] === $level) && ($upgrade["speed"] < $setting["level"])) :
            $entity
                ->setToInstallSpeed(false)
                ->setToInstallUpgrade(false)
                ->setFullSpeed(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["speed"] === $level) && ($upgrade["speed"] === $setting["level"])) :
            $entity
                ->setToInstallSpeed(false)
                ->setToInstallUpgrade(false)
                ->setFullSpeed(true)
                ->setFullUpgrade(false)
            ;
        endif;

        ###### Acceleration
        if (($upgrade["acceleration"] < $level)) :
            $entity
                ->setToInstallAcceleration(true)
                ->setToInstallUpgrade(true)
                ->setFullAcceleration(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["acceleration"] === $level) && ($upgrade["acceleration"] < $setting["level"])) :
            $entity
                ->setToInstallAcceleration(false)
                ->setToInstallUpgrade(false)
                ->setFullAcceleration(false)
                ->setFullUpgrade(false)
            ;

        elseif (($upgrade["acceleration"] === $level) && ($upgrade["acceleration"] === $setting["level"])) :
            $entity
                ->setToInstallAcceleration(false)
                ->setToInstallUpgrade(false)
                ->setFullAcceleration(true)
                ->setFullUpgrade(false)
            ;
        endif;

        ###### Handling
        if (($upgrade["handling"] < $level)) :
            $entity
                ->setToInstallHandling(true)
                ->setToInstallUpgrade(true)
                ->setFullHandling(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["handling"] === $level) && ($upgrade["handling"] < $setting["level"])) :
            $entity
                ->setToInstallHandling(false)
                ->setToInstallUpgrade(false)
                ->setFullHandling(false)
                ->setFullUpgrade(false)
            ;

        elseif (($upgrade["handling"] === $level) && ($upgrade["handling"] === $setting["level"])) :
            $entity
                ->setToInstallHandling(false)
                ->setToInstallUpgrade(false)
                ->setFullHandling(true)
                ->setFullUpgrade(false)
            ;
        endif;

        ###### Nitro
        if (($upgrade["nitro"] < $level)) :
            $entity
                ->setToInstallNitro(true)
                ->setToInstallUpgrade(true)
                ->setFullNitro(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["nitro"] === $level) && ($upgrade["nitro"] < $setting["level"])) :
            $entity
                ->setToInstallNitro(false)
                ->setToInstallUpgrade(false)
                ->setFullNitro(false)
                ->setFullUpgrade(false)
            ;
        elseif (($upgrade["nitro"] === $level) && ($upgrade["nitro"] === $setting["level"])) :
            $entity
                ->setToInstallNitro(false)
                ->setToInstallUpgrade(false)
                ->setFullNitro(true)
                ->setFullUpgrade(false)
            ;
        endif;

        ###### Common
        if ($upgrade["common"] === $setting["common"]):
            $entity
                ->setToInstallCommon(false)
                ->setFullCommon(true)
            ;
        else:
            if ($level > 2) :
                $entity
                    ->setToInstallCommon(true)
                    ->setToInstallImport(true)
                    ->setFullCommon(false)
                    ->setFullImport(false)
                ;
            else:
                $entity
                    ->setToInstallCommon(false)
                    ->setToInstallImport(false)
                    ->setFullCommon(false)
                    ->setFullImport(false)
                ;
            endif;
        endif;

        ###### Rare
        if ($upgrade["rare"] === $setting["rare"]):
            $entity
                ->setToInstallRare(false)
                ->setFullRare(true)
            ;
        else:
            if ($level > 2) :
                $entity
                    ->setToInstallRare(true)
                    ->setToInstallImport(true)
                    ->setFullRare(false)
                    ->setFullImport(false)
                ;
            else:
                $entity
                    ->setToInstallRare(false)
                    ->setToInstallImport(false)
                    ->setFullRare(false)
                    ->setFullImport(false)
                ;
            endif;
        endif;

        ###### Epic
        if ($upgrade["epic"] === $setting["epic"]):
            $entity
                ->setToInstallEpic(false)
                ->setFullEpic(true)
            ;
        else:
            if ($level > 8 && $epic > 0) :
                $entity
                    ->setToInstallEpic(true)
                    ->setToInstallImport(true)
                    ->setFullEpic(false)
                    ->setFullImport(false)
                ;
            else:
                $entity
                    ->setToInstallEpic(false)
                    ->setToInstallImport(false)
                    ->setFullEpic(false)
                    ->setFullImport(false)
                ;
            endif;
        endif;
    }

    /**
     * XXXX
     *
     * @param AppEvent $event
     * @return void
     */
    public static function statusControlFullUpgrade(AppEvent $event): void
    {
        ### Variables
        $upgrade = $event->getUpgrade();
        $setting = $event->getSettingUpgrades();
        $entity  = $event->getGarage()->getStatusControl();

        ### Conditions

        ### upgrades
        if (
            $setting['level'] !== 0 &&
            $upgrade['speed'] === $setting['level'] &&
            $upgrade['acceleration'] === $setting['level'] &&
            $upgrade['handling'] === $setting['level'] &&
            $upgrade['nitro'] === $setting['level']
        ):
            $entity
                ->setToInstallSpeed(false)
                ->setToInstallAcceleration(false)
                ->setToInstallHandling(false)
                ->setToInstallNitro(false)
                ->setToInstallUpgrade(false)

                ->setFullSpeed(true)
                ->setFullAcceleration(true)
                ->setFullHandling(true)
                ->setFullNitro(true)
                ->setFullUpgrade(true)
            ;
        else:
            $entity
                ->setFullSpeed(false)
                ->setFullAcceleration(false)
                ->setFullHandling(false)
                ->setFullNitro(false)

                ->setFullUpgrade(false)
            ;
        endif;

        ### imports
        if (
            $setting['common'] !== 0 &&
            $upgrade['common'] === $setting['common'] &&
            $upgrade['rare'] === $setting['rare'] &&
            $upgrade['epic'] === $setting['epic']
        ):
            $entity
                ->setToInstallCommon(false)
                ->setToInstallRare(false)
                ->setToInstallEpic(false)
                ->setToInstallImport(false)

                ->setFullCommon(true)
                ->setFullRare(true)
                ->setFullEpic(true)
                ->setFullImport(true)
            ;
        else:
            $entity
                ->setToInstallImport(true)
                ->setFullImport(false)
            ;
        endif;
    }

}
