<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Garage;

use App\Application\Event\Garage\AppCreateEvent;
use App\Domain\Entity\GarageBlueprint;
use App\Domain\Entity\GarageGauntlet;
use App\Domain\Entity\GarageRank;
use App\Domain\Entity\GarageStatActual;
use App\Domain\Entity\GarageStatMax;
use App\Domain\Entity\GarageStatMin;
use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\GarageStatusControl;
use App\Domain\Entity\GarageUpgrade;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AddGarageRelationEvent
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}

    /**
     * Initialise les relations Garages.
     * Met à jour les colonnes Settings.
     *
     * @param AppCreateEvent $event
     * @return void
     */
    public function addRelation(AppCreateEvent $event): void
    {
        $garage = $event->getGarage();

        ### Get Settings
        $blueprintEntity = $event->getSettingBlueprint();
        $levelEntity     = $event->getSettingLevel();
        $unitPriceEntity = $event->getSettingUnitPrice();

        ### Add Relations
        $event->getGarage()->setSettingBlueprint($blueprintEntity);
        $event->getGarage()->setSettingLevel($levelEntity);
        $event->getGarage()->setSettingUnitPrice($unitPriceEntity);

        $blueprint = new GarageBlueprint();
        $blueprint->setGarage($garage);
        $this->entityManager->persist($blueprint);

        $gauntlet = new GarageGauntlet();
        $gauntlet->setGarage($garage);
        $this->entityManager->persist($gauntlet);

        $rank = new GarageRank();
        $rank->setGarage($garage);
        $this->entityManager->persist($rank);

        $actual = new GarageStatActual();
        $actual->setGarage($garage);
        $this->entityManager->persist($actual);

        $max = new GarageStatMax();
        $max->setGarage($garage);
        $this->entityManager->persist($max);

        $min = new GarageStatMin();
        $min->setGarage($garage);
        $this->entityManager->persist($min);

        $status = new GarageStatus();
        $status->setGarage($garage);
        $this->entityManager->persist($status);

        $control = new GarageStatusControl();
        $control->setGarage($garage);
        $this->entityManager->persist($control);

        $upgrade = new GarageUpgrade();
        $upgrade->setGarage($garage);
        $this->entityManager->persist($upgrade);
    }
}
