<?php

    /**
     * Détermine si la voiture est bloquée en fonction des cartes
     *
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function stateLocked(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function stateFullBlueprint(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function stateGold(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function toUnlock(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function toUpgrade(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function toGold(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function toInstall(GarageBooleanEvent $event): void
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
     * @param GarageBooleanEvent $event
     * @return void
     */
    public function toFull(GarageBooleanEvent $event): void
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
