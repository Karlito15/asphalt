<?php

namespace App\EventSubscriber;

use App\Entity\AppGarage;
use App\Entity\GarageBoolean;
use App\Event\BooleanGarageEvent;
use App\Event\OrderCarGarageEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class GarageUpdateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    /**
     * @return array[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            OrderCarGarageEvent::class => [
                ['orderByClass', 1001],
                ['orderByStat', 1000],
            ],
            BooleanGarageEvent::class => [
                ['stateLocked', 1099],
                ['stateFullBlueprint', 1098],
                ['stateGold', 1097],
                ['toUnlock', 1096],
//                ['toUpgrade', 1095],
                ['toGold', 1094],
                ['toInstall', 1093],
                ['toFull', 1092],
            ],
        ];
    }

    /**
     * Calcule la position de la voiture en fonction de sa Class
     *
     * @param OrderCarGarageEvent $event
     * @return void
     */
    public function orderByClass(OrderCarGarageEvent $event): void
    {
        if ($event->garage instanceof AppGarage) {
            /** @var AppGarage $item */
            // Update Car
            $class    = $event->garage->getSettingClass()->getValue();
            $garages  = $this->entityManager->getRepository(AppGarage::class)->getCarsByClass($class);
            $position = $event->garage->getCarOrder();
            $event->garage->setCarOrder($position);
            $this->entityManager->persist($event->garage);

            // Re Order Other Cars After New Position
            $list     = [];
            $id       = $event->garage->getId();
            foreach ($garages as $item) {
                if ($item->getCarOrder() >= $position && $item->getCarOrder() < 90 && $item->getId() != $id) {
                    $list[] = $item;
                }
            }

            $pos = $position +1;
            foreach ($list as $item) {
                $item->setCarOrder($pos++);
                $this->entityManager->persist($item);
            }
            $this->entityManager->flush();
        }
    }

    /**
     * Calcule la position de la voiture en fonction des Stats
     *
     * @param OrderCarGarageEvent $event
     * @return void
     */
    public function orderByStat(OrderCarGarageEvent $event): void
    {
        $datas    = [];
        $position = 0;
        if ($event->garage instanceof AppGarage) {
            /** @var AppGarage $item */
            $class    = $event->garage->getSettingClass()->getValue();
            $garages  = $this->entityManager->getRepository(AppGarage::class)->getCarsByClass($class);

            foreach ($garages as $item) {
                $datas[] = [
                    'id'         => $item->getId(),
                    'averageMax' => $item->getStatMax()->getValues()[0]->getAverage(),
                ];
                $avMax = array_column($datas, 'averageMax');
                array_multisort($avMax, SORT_DESC, SORT_NUMERIC, $datas);
            }

            foreach ($datas as $data) {
                $position++;
                $garage = $this->entityManager->getRepository(AppGarage::class)->findOneBy(['id' => $data['id']]);
                $garage->setStatOrder($position);
                $this->entityManager->persist($garage);
            }
            $this->entityManager->flush();
        }
    }

    /**
     * Détermine si la voiture est bloquée en fonction des cartes
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function stateLocked(BooleanGarageEvent $event): void
    {
        // Get Values
        $blueprint = $event->getBlueprint();
        $setting   = $event->getSettingBlueprint();
        $garage    = $event->garage->getBoolean()->getValues()[0];
        // Conditions
        if ($garage instanceof GarageBoolean) {
            if($blueprint->getStar1() === $setting->getStar1()) {
                $garage->setLocked(false);
            } else {
                $garage->setLocked(true);
            }
        }
    }

    /**
     * Détermine si la voiture a toutes les cartes
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function stateFullBlueprint(BooleanGarageEvent $event): void
    {
        // Get Values
        $blueprint = $event->getBlueprint();
        $setting   = $event->getSettingBlueprint();
        $garage    = $event->garage->getBoolean()->getValues()[0];
        // Conditions
        if ($garage instanceof GarageBoolean) {
            if ($blueprint->getTotal() === $setting->getTotal()) {
                $garage->setFullBlueprint(true);
            } else {
                $garage->setFullBlueprint(false);
            }
        }
    }

    /**
     * Détermine si la voiture est au niveau Gold
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function stateGold(BooleanGarageEvent $event): void
    {
        // Get Values
        $garage  = $event->garage->getBoolean()->getValues()[0];
        $setting = $event->getSettingLevel();
        // Conditions
        if ($garage instanceof GarageBoolean) {
            if (
                $garage->isFullBlueprint() AND
                $garage->isFullCommon() AND
                $garage->isFullRare() AND
                $garage->isFullEpic() AND
                $event->garage->getLevel() == $setting->getLevel() AND
                $event->garage->getEpic() == $setting->getEpic()
            ) {
                $garage->setGold(true);
            } else {
                $garage->setGold(false);
            }
        }
    }

    /**
     * Détermine si la voiture doit être débloquée en fonction de sa moyenne
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function toUnlock(BooleanGarageEvent $event): void
    {
        // Get Values
        $garage = $event->garage->getBoolean()->getValues()[0];
        // Conditions
        if ($garage instanceof GarageBoolean) {
            if ($event->getAverageMax() >= $event->getMedian()) {
                $garage->setToUnlock(true);
            }
        }
    }

    /**
     * To Do
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function toUpgrade(BooleanGarageEvent $event): void
    {
        // Get Values
        $garage = $event->garage->getBoolean()->getValues()[0];
        // Conditions
        if ($garage instanceof GarageBoolean) {
            dump('ToDo');
        }
    }

    /**
     * Détermine si la voiture à toutes les cartes, toutes les épics et n'est pas encore en Gold
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function toGold(BooleanGarageEvent $event): void
    {
        // Get Values
        $garage  = $event->garage->getBoolean()->getValues()[0];
        $setting = $event->getSettingLevel();
        // Conditions
        if ($garage instanceof GarageBoolean) {
            /** Si on a toutes les cartes && Si on a toutes les épics && voiture pas encore en gold */
            if ($garage->isFullBlueprint() AND ($setting->getEpic() === $garage->getGarage()->getEpic()) AND $garage->isGold() === false) {
                $garage->setToGold(true);
            } else {
                $garage->setToGold(false);
            }
        }
    }

    /**
     * Détermine si des upgrades doivent être installées
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function toInstall(BooleanGarageEvent $event): void
    {
        // Get Values
        $setting      = $event->getSettingLevel();
        $garage       = $event->garage->getBoolean()->getValues()[0];
        $upgrade      = $event->getUpgrade();
        // Conditions Speed
        if ($event->garage->getLevel() > $upgrade->getSpeed()) {
            $garage->setInstallSpeed(true);
            $garage->setFullSpeed(false);
        } else {
            $garage->setInstallSpeed(false);
        }
        // Conditions Acceleration
        if ($event->garage->getLevel() > $upgrade->getAcceleration()) {
            $garage->setInstallAcceleration(true);
            $garage->setFullAcceleration(false);
        } else {
            $garage->setInstallAcceleration(false);
        }
        // Conditions Handly
        if ($event->garage->getLevel() > $upgrade->getHandly()) {
            $garage->setInstallHandly(true);
            $garage->setFullHandly(false);
        } else {
            $garage->setInstallHandly(false);
        }
        // Conditions Nitro
        if ($event->garage->getLevel() > $upgrade->getNitro()) {
            $garage->setInstallNitro(true);
            $garage->setFullNitro(false);
        } else {
            $garage->setInstallNitro(false);
        }
        // Conditions Common
        if ($setting->getCommon() > $upgrade->getCommon()) {
            $garage->setInstallCommon(true);
            $garage->setFullCommon(false);
        } else {
            $garage->setInstallCommon(false);
        }
        // Conditions Rare
        if ($setting->getRare() > $upgrade->getRare()) {
            $garage->setInstallRare(true);
            $garage->setFullRare(false);
        } else {
            $garage->setInstallRare(false);
        }
        // Conditions Epic
        if ($setting->getEpic() > $upgrade->getEpic()) {
            $garage->setInstallEpic(true);
            $garage->setFullEpic(false);
        } else {
            $garage->setInstallEpic(false);
        }
    }

    /**
     * Détermine si toutes les upgrades sont installées
     *
     * @param BooleanGarageEvent $event
     * @return void
     */
    public function toFull(BooleanGarageEvent $event): void
    {
        // Get Values
        $setting      = $event->getSettingLevel();
        $garage       = $event->garage->getBoolean()->getValues()[0];
        $upgrade      = $event->getUpgrade();
        // Conditions Speed
        if ($setting->getLevel() === $upgrade->getSpeed()) {
            $garage->setInstallSpeed(false);
            $garage->setFullSpeed(true);
        } else {
            $garage->setFullSpeed(false);
        }
        // Conditions Acceleration
        if ($setting->getLevel() === $upgrade->getAcceleration()) {
            $garage->setInstallAcceleration(false);
            $garage->setFullAcceleration(true);
        } else {
            $garage->setFullAcceleration(false);
        }
        // Conditions Handly
        if ($setting->getLevel() === $upgrade->getHandly()) {
            $garage->setInstallHandly(false);
            $garage->setFullHandly(true);
        } else {
            $garage->setFullHandly(false);
        }
        // Conditions Nitro
        if ($setting->getLevel() === $upgrade->getNitro()) {
            $garage->setInstallNitro(false);
            $garage->setFullNitro(true);
        } else {
            $garage->setFullNitro(false);
        }
        // Conditions Common
        if ($setting->getCommon() === $upgrade->getCommon()) {
            $garage->setInstallCommon(false);
            $garage->setFullCommon(true);
        } else {
            $garage->setFullCommon(false);
        }
        // Conditions Rare
        if ($setting->getRare() === $upgrade->getRare()) {
            $garage->setInstallRare(false);
            $garage->setFullRare(true);
        } else {
            $garage->setFullRare(false);
        }
        // Conditions Epic
        if ($setting->getEpic() === $upgrade->getEpic()) { // AND $setting->getEpic() === $event->garage->getEpic()
            $garage->setInstallEpic(false);
            $garage->setFullEpic(true);
        } else {
            $garage->setFullEpic(false);
        }
    }
}
