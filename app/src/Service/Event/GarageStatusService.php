<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Event\Garage\UpdateEvent;

class GarageStatusService
{
    /**
     * Détermine si la voiture est bloquée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isUnblock(UpdateEvent $event): void
    {
        // Get Values
        $garage    = $event->garage;
        $blueprint = $event->getBlueprint();
        $setting   = $event->getSettingBlueprint();

        if ($garage instanceof GarageApp) {
            $status = $event->getStatus();

            // Conditions
            if($blueprint->getStar1() === $setting->getStar1()) {
                $status->setUnblock(true);
            } else {
                $status->setUnblock(false);
            }
        }
    }

    /**
     * Détermine si la voiture doit être débloquée
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isToUnblock(UpdateEvent $event): void
    {
        // Get Values
        $garage     = $event->garage;
        $averageMax = $event->getAverageMax();
        $median     = $event->getMedian();
        $status     = $event->getStatus();

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($averageMax >= $median) {
                $status->setToUnblock(true);
            } else {
                $status->setToUnblock(false);
            }
        }
    }

    /**
     * Détermine si la voiture est au niveau Gold
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isGold(UpdateEvent $event): void
    {
        // Get Values
        $garage  = $event->garage;
        $upgrade = $event->getUpgrade();
        $setting = $event->getSettingLevel();
        $status  = $event->getStatus();

        if ($garage instanceof GarageApp) {
            // Conditions
            if (
                $garage->getLevel() === $setting->getLevel() &&
                $upgrade->getEpic() === $setting->getEpic()
            ) {
//                if (
//                    $status->isFullUpgradeLevel() &&
//                    $status->isFullUpgradeSpeed() &&
//                    $status->isFullUpgradeAcceleration() &&
//                    $status->isFullUpgradeHandling() &&
//                    $status->isFullUpgradeNitro() &&
//                    $status->isFullUpgradeCommon() &&
//                    $status->isFullUpgradeRare() &&
//                    $status->isFullUpgradeEpic()
//                ) {
//                    $status->setGold(true);
//                } else {
//                    $status->setGold(false);
//                }
                $status->setGold(true);
            } else {
                $status->setGold(false);
            }
        }
    }

    /**
     * Détermine si la voiture peut atteindre le niveau maximum
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isToGold(UpdateEvent $event): void
    {
        // Get Values
        $garage       = $event->garage;
        $garage_total = $event->getBlueprint()->getTotal();
        $target_total = $event->getSettingBlueprint()->getTotal();
        $status       = $event->getStatus();

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($status->isGold()) {
                // Garage is already Gold
                $status->setToGold(false);
            } else {
                if (
                    // Blueprints
                    $garage_total === $target_total &&
                    // Levels
                    $event->garage->getLevel() === $event->getSettingLevel()->getLevel() &&
                    // Epics
                    $event->garage->getEpic() === $event->getSettingLevel()->getEpic()
                ) {
                    $status->setToGold(true);
                } else {
                    $status->setToGold(false);
                }
            }
        }
    }

    /**
     * Détermine si toutes les upgrades sont installées pour une catégorie donnée
     *
     * @param UpdateEvent $event
     * @param string $upgrade
     * @return void
     */
    public function isFullUpgrade(UpdateEvent $event, string $upgrade): void
    {
        // Get Values
        $garage        = $event->garage;
        $status        = $event->getStatus();
        $upgrades      = match ($upgrade) {
            'Speed'        => $event->getUpgrade()->getSpeed(),
            'Acceleration' => $event->getUpgrade()->getAcceleration(),
            'Handling'     => $event->getUpgrade()->getHandling(),
            'Nitro'        => $event->getUpgrade()->getNitro(),
        };

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($upgrades === $event->getSettingLevel()->getLevel()) {
                match ($upgrade) {
                    'Speed'        => $status->setFullUpgradeSpeed(true),
                    'Acceleration' => $status->setFullUpgradeAcceleration(true),
                    'Handling'     => $status->setFullUpgradeHandling(true),
                    'Nitro'        => $status->setFullUpgradeNitro(true),
                };
            } else {
                match ($upgrade) {
                    'Speed'        => $status->setFullUpgradeSpeed(false),
                    'Acceleration' => $status->setFullUpgradeAcceleration(false),
                    'Handling'     => $status->setFullUpgradeHandling(false),
                    'Nitro'        => $status->setFullUpgradeNitro(false),
                };
            }
        }
    }

    /**
     * Détermine si tous les imports sont installés pour une catégorie donnée
     *
     * @param UpdateEvent $event
     * @param string $import
     * @return void
     */
    public function isFullImport(UpdateEvent $event, string $import): void
    {
        // Get Values
        $garage       = $event->garage;
        $status       = $event->getStatus();
        $imports      = match ($import) {
            'Common' => $event->getUpgrade()->getCommon(),
            'Rare'   => $event->getUpgrade()->getRare(),
            'Epic'   => $event->getUpgrade()->getEpic(),
        };

        if ($garage instanceof GarageApp) {
            // Conditions
            switch ($import) {
                case 'Common':
                    if ($event->getSettingLevel()->getCommon() === $imports) {
                        $status->setFullUpgradeCommon(true);
                        $status->setToInstallUpgradeCommon(false);
                    } else {
                        $status->setFullUpgradeCommon(false);
                        $status->setToInstallUpgradeCommon(true);
                    }
                    break;
                case 'Rare':
                    if ($event->getSettingLevel()->getRare() === $imports) {
                        $status->setFullUpgradeRare(true);
                        $status->setToInstallUpgradeRare(false);
                    } else {
                        $status->setFullUpgradeRare(false);
                        $status->setToInstallUpgradeRare(true);
                    }
                    break;
                case 'Epic':
                    if ($event->getSettingLevel()->getEpic() === $imports) {
                        $status->setFullUpgradeEpic(true);
                        $status->setToInstallUpgradeEpic(false);
                    } else {
                        $status->setFullUpgradeEpic(false);
                        $status->setToInstallUpgradeEpic(true);
                    }
                    break;
            }
        }
    }

    public function isToInstallUpgrade(UpdateEvent $event, string $upgrade): void
    {
        // Get Values
        $garage         = $event->garage;
        $status         = $event->getStatus();
        $upgrades       = match ($upgrade) {
            'Speed'        => $event->getUpgrade()->getSpeed(),
            'Acceleration' => $event->getUpgrade()->getAcceleration(),
            'Handling'     => $event->getUpgrade()->getHandling(),
            'Nitro'        => $event->getUpgrade()->getNitro(),
        };

        if ($garage instanceof GarageApp) {
            // Conditions
            if ($upgrades < $garage->getLevel()) {
                match ($upgrade) {
                    'Speed'        => $status->setToInstallUpgradeSpeed(true),
                    'Acceleration' => $status->setToInstallUpgradeAcceleration(true),
                    'Handling'     => $status->setToInstallUpgradeHandling(true),
                    'Nitro'        => $status->setToInstallUpgradeNitro(true),
                };
            } else {
                match ($upgrade) {
                    'Speed'        => $status->setToInstallUpgradeSpeed(false),
                    'Acceleration' => $status->setToInstallUpgradeAcceleration(false),
                    'Handling'     => $status->setToInstallUpgradeHandling(false),
                    'Nitro'        => $status->setToInstallUpgradeNitro(false),
                };
            }
        }
    }
}
