<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Event\Setting;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Entity\StatisticalGarage;
use App\Infrastructure\Event\Garage\SettingEvent;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Count
{
    /**
     * Compte le nombre de voitures par Marque
     *
     * @param SettingEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public static function byBrand(SettingEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->getGarage()->getSettingBrand() instanceof SettingBrand)
        {
            $brand  = $manager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getName()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingBrand' => $brand]);
            $result = (count($garage));
            $brand->setCarsNumber($result);
        }
    }

    /**
     * Compte le nombre de voitures par Class
     *
     * @param SettingEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public static function byClass(SettingEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->getGarage()->getSettingClass() instanceof SettingClass)
        {
            $class  = $manager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getValue()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $result = (count($garage));
            $class->setCarsNumber($result);
        }
    }
}
