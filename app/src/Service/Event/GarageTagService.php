<?php

namespace App\Service\Event;

class GarageTagService
{
//    /**
//     * Détermine si la voiture a toutes les cartes
//     *
//     * @param UpdateEvent $event
//     * @return void
//     */
//    public function isBlueprintFull(UpdateEvent $event): void
//    {
//        // Get Values
//        $blueprint = $event->getBlueprint();
//        $setting   = $event->getSettingBlueprint();
//        $garage    = $event->garage->getBoolean()->getValues()[0];
//        // Conditions
//        if ($garage instanceof GarageBoolean) {
//            if ($blueprint->getTotal() === $setting->getTotal()) {
//                $garage->setFullBlueprint(true);
//            } else {
//                $garage->setFullBlueprint(false);
//            }
//        }
//    }
//
//    /**
//     * Détermine si la voiture doit être débloquée en fonction de sa moyenne
//     *
//     * @param UpdateEvent $event
//     * @return void
//     */
//    public function toUnlock(UpdateEvent $event): void
//    {
//        // Get Values
//        $garage = $event->garage->getBoolean()->getValues()[0];
//        // Conditions
//        if ($garage instanceof GarageBoolean) {
//            if ($event->getAverageMax() >= $event->getMedian()) {
//                $garage->setToUnlock(true);
//            }
//        }
//    }
//
//    /**
//     * Détermine si la voiture à toutes les cartes, toutes les épics et n'est pas encore en Gold
//     *
//     * @param UpdateEvent $event
//     * @return void
//     */
//    public function toGold(UpdateEvent $event): void
//    {
//        // Get Values
//        $garage  = $event->garage->getBoolean()->getValues()[0];
//        $setting = $event->getSettingLevel();
//        // Conditions
//        if ($garage instanceof GarageBoolean) {
//            /** Si on a toutes les cartes && Si on a toutes les épics && voiture pas encore en gold */
//            if ($garage->isFullBlueprint() AND ($setting->getEpic() === $garage->getGarage()->getEpic()) AND $garage->isGold() === false) {
//                $garage->setToGold(true);
//            } else {
//                $garage->setToGold(false);
//            }
//        }
//    }
}
