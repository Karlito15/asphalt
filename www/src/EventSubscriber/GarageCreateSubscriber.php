<?php

namespace App\EventSubscriber;

use App\Entity\AppGarage;
use App\Entity\GarageBlueprint;
use App\Entity\GarageBoolean;
use App\Entity\GarageRank;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use App\Entity\GarageUpgrade;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingUnitPrice;
use App\Event\GarageCreateEvent;
use App\Event\SettingBrandEvent;
use App\Event\SettingClassEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class GarageCreateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
			SettingBrandEvent::class => 'countCarsByBrand',
			SettingClassEvent::class => 'countCarsByClass',
			GarageCreateEvent::class => 'onGarageCreate',
        ];
    }

    /**
     * Compte le nombre de voitures par Marque
     *
     * @param SettingBrandEvent $event
     * @return void
     */
    public function countCarsByBrand(SettingBrandEvent $event): void
    {
        if ($event->garage->getSettingBrand() instanceof SettingBrand) {
            $brand  = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getName()]);
            $result = $this->entityManager->getRepository(AppGarage::class)->findBy(['settingBrand' => $brand]);
            $brand->setCarsNumber(count($result));
            $this->entityManager->persist($brand);
            $this->entityManager->flush();
        }
    }

	/**
	 * Compte le nombre de voitures par Class
	 *
	 * @param SettingClassEvent $event
	 * @return void
	 */
    public function countCarsByClass(SettingClassEvent $event): void
    {
        if ($event->garage->getSettingClass() instanceof SettingClass) {
            $class  = $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getClass()]);
            $result = $this->entityManager->getRepository(AppGarage::class)->findBy(['settingClass' => $class]);
            $class->setCarsNumber(count($result));
            $this->entityManager->persist($class);
            $this->entityManager->flush();
        }
    }

    /**
     * Initialise les entités Garages.
     * Remplie les colonnes Settings.
     *
     * @param GarageCreateEvent $event
     * @return void
     */
    public function onGarageCreate(GarageCreateEvent $event): void
    {
        $blueprint  = "099 - 99 - 99 - 99 - 99 - 99 || 594";
        $level      = "99 || 99 - 99 - 99";
        $unitPrice  = "6999984 || 99999 - 99999 - 99999 - 99999 - 999999 - 999999";

        if ($event->garage instanceof AppGarage) {
	        $event->garage->addBlueprint(new GarageBlueprint());
	        $event->garage->addBoolean(new GarageBoolean());
	        $event->garage->addRank(new GarageRank());
	        $event->garage->addStatMax(new GarageStatMax());
	        $event->garage->addStatMin(new GarageStatMin());
	        $event->garage->addUpgrade(new GarageUpgrade());
            $event->garage->setSettingBlueprint($this->entityManager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $blueprint]));
            $event->garage->setSettingLevel($this->entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => $level]));
            $event->garage->setSettingUnitPrice($this->entityManager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => $unitPrice]));
        }
    }
}
