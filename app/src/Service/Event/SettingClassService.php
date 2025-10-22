<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Entity\SettingClass;
use App\Event\Setting\ClassEvent;
use Doctrine\ORM\EntityManagerInterface;

class SettingClassService
{
    /**
     * Compte le nombre de voitures par Class
     * Met à jour l'entitée SettingClass
     *
     * @param ClassEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function countCarsByClass(ClassEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage->getSettingClass() instanceof SettingClass) {
            $class  = $manager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getClass()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $result = (count($garage) + 1);
            $class->setCarsNumber($result);
            $manager->persist($class);
            $manager->flush();
        }
    }
}
