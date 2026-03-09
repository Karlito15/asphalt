<?php

declare(strict_types=1);

namespace App\Service\Event\Setting;

use App\Event\Setting\ClassEvent;
use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingClass;
use Doctrine\ORM\EntityManagerInterface;

final class ClassService
{
    /**
     * Compte le nombre de voitures par Class
     * Met à jour une entité SettingClass
     *
     * @param ClassEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function countCarsByClass(ClassEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->getGarage()->getSettingClass() instanceof SettingClass) {
            $class  = $manager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getClass()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $result = (count($garage));
            $class->setCarsNumber($result);
            $manager->persist($class);
        }
    }
}
