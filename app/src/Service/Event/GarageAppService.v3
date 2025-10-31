<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Entity\SettingBlueprint;
use App\Entity\SettingLevel;
use App\Entity\SettingTag;
use App\Entity\SettingUnitPrice;
use App\Event\Garage\CreateEvent;
use App\Event\Garage\UpdateEvent;
use Doctrine\ORM\EntityManagerInterface;

class GarageAppService
{
    /**
     * Initialise les entités Garages.
     * Met à jour les colonnes Settings.
     *
     * @param CreateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function initGarage(CreateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            // Init Garages Entities
            $event->garage->addBlueprint(new GarageBlueprint());
            $event->garage->addGauntlet(new GarageGauntlet());
            $event->garage->addRank(new GarageRank());
            $event->garage->addStatMax(new GarageStatMax());
            $event->garage->addStatMin(new GarageStatMin());
            $event->garage->addUpgrade(new GarageUpgrade());
            // Settings Entities
            $blueprint       = "099 - 99 - 99 - 99 - 99 - 99 || 594";
            $level           = "99 || 99 - 99 - 99";
            $unitPrice       = "6999984 || 99999 - 99999 - 99999 - 99999 - 999999 - 999999";
            $blueprintEntity = $manager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $blueprint]);
            $levelEntity     = $manager->getRepository(SettingLevel::class)->findOneBy(['slug' => $level]);
            $unitPriceEntity = $manager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => $unitPrice]);
            $event->garage->setSettingBlueprint($blueprintEntity);
            $event->garage->setSettingLevel($levelEntity);
            $event->garage->setSettingUnitPrice($unitPriceEntity);
        }
    }

    /**
     * Calcule la position de la voiture en fonction de sa Class
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function orderByClass(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            // Update Garage
            $class    = $event->getClass();
            $garages  = $manager->getRepository(GarageApp::class)->getCarsByClass($class);
            $position = $event->getOrderPositionByClass();
            $event->garage->setCarOrder($position);
            $manager->persist($event->garage);

            // Re Order Other Cars After New Position
            $list     = [];
            $id       = $event->getId();
            foreach ($garages as $garage) {
                /** @var GarageApp $garage */
                if (
                    $garage->getCarOrder() >= $position &&
                    $garage->getCarOrder() < 90 && $garage->getId() !== $id
                ) {
                    $list[] = $garage;
                }
            }

            $pos = $position +1;
            foreach ($list as $item) {
                $item->setCarOrder($pos++);
                $manager->persist($item);
            }
            $manager->flush();
            $manager->clear();
        }
    }

    /**
     * Calcule la position de la voiture en fonction des Stats
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function orderByStat(UpdateEvent $event, EntityManagerInterface $manager): void{
        $datas    = [];
        $position = 0;
        if ($event->garage instanceof GarageApp) {
            $class    = $event->getClass();
            $garages  = $manager->getRepository(GarageApp::class)->getCarsByClass($class);

            /** @var GarageApp $garage */
            foreach ($garages as $garage) {
                $datas[] = [
                    'id'         => $garage->getId(),
                    'averageMax' => $garage->getStatMax()->getValues()[0]->getAverage(),
                ];
                $avMax = array_column($datas, 'averageMax');
                array_multisort($avMax, SORT_DESC, SORT_NUMERIC, $datas);
            }

            foreach ($datas as $data) {
                $position++;
                $garage = $manager->getRepository(GarageApp::class)->findOneBy(['id' => $data['id']]);
                $garage->setStatOrder($position);
                $manager->persist($garage);
            }
            $manager->flush();
            $manager->clear();
        }
    }

    /**
     * Détermine si la voiture est bloquée en fonction des cartes
     *
     * @param UpdateEvent $event
     * @return void
     */
    public function isUnlocked(UpdateEvent $event): void
    {
        // Get Values
        $garage    = $event->garage;
        $blueprint = $event->getBlueprint();
        $setting   = $event->getSettingBlueprint();
        // Conditions
        if ($garage instanceof GarageApp) {
            if($blueprint->getStar1() === $setting->getStar1()) {
                $garage->setUnlocked(true);
            } else {
                $garage->setUnlocked(false);
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
        // Conditions
        if ($garage instanceof GarageApp) {
            if (
                $garage->getLevel() === $setting->getLevel() &&
                $upgrade->getEpic() === $setting->getEpic()
            ) {
                $garage->setGold(true);
            } else {
                $garage->setGold(false);
            }
        }
    }

    /**
     * Détermine si la voiture doit être débloquée
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function isToUnlock(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            $averageMax = $event->getAverageMax();
            $median = $event->getMedian();
            if ($averageMax >= $median) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'to-unlock']);
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si la voiture peut atteindre le niveau maximum
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function isToGold(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            $garage_total = $event->getBlueprint()->getTotal();
            $target_total = $event->getSettingBlueprint()->getTotal();
            if (
                // All Blueprint
                $garage_total === $target_total &&
                // All Level
                $event->garage->getLevel() === $event->getSettingLevel()->getLevel() &&
                // All Epic
                $event->garage->getEpic() === $event->getSettingLevel()->getEpic()
            ) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'to-gold']);
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si la voiture a obtenu toutes les cartes
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function isFullBlueprint(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            $garage_total = $event->getBlueprint()->getTotal();
            $target_total = $event->getSettingBlueprint()->getTotal();

            if ($garage_total === $target_total) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-blueprint']);
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si toutes les upgrades sont installées dans une catégorie donnée
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @param string $upgrade
     * @return void
     */
    public function isFullUpgrade(UpdateEvent $event, EntityManagerInterface $manager, string $upgrade): void
    {
        if ($event->garage instanceof GarageApp) {
            // Get Max Level
            $upgrade_total = $event->getSettingLevel()->getLevel();

            // Get Upgrade by Category
            $garage = match ($upgrade) {
                'Speed'        => $event->getUpgrade()->getSpeed(),
                'Acceleration' => $event->getUpgrade()->getAcceleration(),
                'Handling'     => $event->getUpgrade()->getHandling(),
                'Nitro'        => $event->getUpgrade()->getNitro(),
            };

            if ($upgrade_total === $garage) {
                $tag = match ($upgrade) {
                    'Speed'        => $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-speed']),
                    'Acceleration' => $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-acceleration']),
                    'Handling'     => $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-handling']),
                    'Nitro'        => $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-nitro']),
                };
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si tous les imports sont installés dans une catégorie donnée
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @param string $import
     * @return void
     */
    public function isFullImport(UpdateEvent $event, EntityManagerInterface $manager, string $import): void
    {
        if ($event->garage instanceof GarageApp) {
            // Get Max Level
            $common_total = $event->getSettingLevel()->getCommon();
            $rare_total   = $event->getSettingLevel()->getRare();
            $epic_total   = $event->getSettingLevel()->getEpic();

            // Get Upgrade by Category
            $garage = match ($import) {
                'Common' => $event->getUpgrade()->getCommon(),
                'Rare'   => $event->getUpgrade()->getRare(),
                'Epic'   => $event->getUpgrade()->getEpic(),
            };

            if ($import === 'Common' && $common_total === $garage) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-common']);
                $event->garage->addSettingTag($tag);
            }

            if ($import === 'Rare' && $rare_total === $garage) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-rare']);
                $event->garage->addSettingTag($tag);
            }

            if ($import === 'Epic' && $epic_total === $garage) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-epic']);
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si la voiture a atteint le niveau maximum dans toutes les catégories
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function isFullAllUpgrades(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            // Get Max Level
            $upgrade_total = $event->getSettingLevel()->getLevel();
            if (
                $upgrade_total === $event->getUpgrade()->getSpeed() &&
                $upgrade_total === $event->getUpgrade()->getAcceleration() &&
                $upgrade_total === $event->getUpgrade()->getHandling() &&
                $upgrade_total === $event->getUpgrade()->getNitro()
            ) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-upgrades']);
                $event->garage->addSettingTag($tag);
            }
        }
    }

    /**
     * Détermine si la voiture a atteint le niveau maximum dans toutes les catégories
     *
     * @param UpdateEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function isFullAllImports(UpdateEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage instanceof GarageApp) {
            // Get Max Level
            $common_total  = $event->getSettingLevel()->getCommon();
            $rare_total    = $event->getSettingLevel()->getRare();
            $epic_total    = $event->getSettingLevel()->getEpic();
            if (
                $common_total === $event->getUpgrade()->getCommon() &&
                $rare_total === $event->getUpgrade()->getRare() &&
                $epic_total === $event->getUpgrade()->getEpic()
            ) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-imports']);
                $event->garage->addSettingTag($tag);
            }
        }
    }
}
