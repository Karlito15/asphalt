<?php

declare(strict_types=1);

namespace App\Service\Event\Garage;

use App\Event\Garage\AppCreateEvent;
use Doctrine\ORM\EntityManagerInterface;

class GarageAppService
{
    /**
     * Initialise les relations Garages.
     * Met à jour les colonnes Settings.
     *
     * @param AppCreateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function initGarage(AppCreateEvent $event, EntityManagerInterface $manager): void
    {
//        if ($event->garage instanceof GarageApp) {
//            // Settings Entities
//            $blueprint       = "099-99-99-99-99-99|594";
//            $level           = "99|99-99-99";
//            $unitPrice       = "6999984|99999-99999-99999-99999-999999-999999";
//            $blueprintEntity = $manager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $blueprint]);
//            $levelEntity     = $manager->getRepository(SettingLevel::class)->findOneBy(['slug' => $level]);
//            $unitPriceEntity = $manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => $unitPrice]);
//            // Init Garages Entities
//            $event->garage->addBlueprint(new GarageBlueprint());
//            $event->garage->addGauntlet(new GarageGauntlet());
//            $event->garage->addRank(new GarageRank());
//            $event->garage->addStatus(new GarageStatus());
//            $event->garage->addStatActual(new GarageStatActual());
//            $event->garage->addStatMax(new GarageStatMax());
//            $event->garage->addStatMin(new GarageStatMin());
//            $event->garage->addUpgrade(new GarageUpgrade());
//            $event->garage->setSettingBlueprint($blueprintEntity);
//            $event->garage->setSettingLevel($levelEntity);
//            $event->garage->setSettingUnitPrice($unitPriceEntity);
//        }
    }
}
