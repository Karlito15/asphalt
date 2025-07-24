<?php

namespace App\EventSubscriber\Garage;

use App\Entity\GarageApp;
use App\Entity\GarageBlueprint;
use App\Entity\GarageRank;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use App\Entity\GarageUpgrade;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingUnitPrice;
use App\Event\Garage\CreateEvent;
use App\Event\Setting\BrandEvent;
use App\Event\Setting\ClassEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class CreateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            BrandEvent::class => 'countCarsByBrand',
            ClassEvent::class => 'countCarsByClass',
            CreateEvent::class => 'onGarageCreate',
        ];
    }

    /**
     * Compte le nombre de voitures par Marque
     *
     * @param BrandEvent $event
     * @return void
     */
    public function countCarsByBrand(BrandEvent $event): void
    {
        if ($event->garage->getSettingBrand() instanceof SettingBrand) {
            $brand  = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getName()]);
            $result = $this->entityManager->getRepository(GarageApp::class)->findBy(['settingBrand' => $brand]);
            $brand->setCarsNumber(count($result) + 1);
            $this->entityManager->persist($brand);
            $this->entityManager->flush();
        }
    }

    /**
     * Compte le nombre de voitures par Class
     *
     * @param ClassEvent $event
     * @return void
     */
    public function countCarsByClass(ClassEvent $event): void
    {
        if ($event->garage->getSettingClass() instanceof SettingClass) {
            $class  = $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getClass()]);
            $result = $this->entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $class->setCarsNumber(count($result) + 1);
            $this->entityManager->persist($class);
            $this->entityManager->flush();
        }
    }

    /**
     * Initialise les entités Garages.
     * Remplie les colonnes Settings.
     *
     * @param CreateEvent $event
     * @return void
     */
    public function onGarageCreate(CreateEvent $event): void
    {
        $blueprint  = "099 - 99 - 99 - 99 - 99 - 99 || 594";
        $level      = "99 || 99 - 99 - 99";
        $unitPrice  = "6999984 || 99999 - 99999 - 99999 - 99999 - 999999 - 999999";

        if ($event->garage instanceof GarageApp) {
            $event->garage->addBlueprint(new GarageBlueprint());
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
