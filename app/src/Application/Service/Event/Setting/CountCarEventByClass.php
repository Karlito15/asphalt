<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Setting;

use App\Application\Event\Setting\ClassEvent;
use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingClass;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CountCarEventByClass
{
    /**
     * Compte le nombre de voitures par Class
     * Met à jour l'entité SettingClass
     *
     * @param ClassEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function countCarsByClass(
        ClassEvent $event,
        EntityManagerInterface $manager
    ): void
    {
        if ($event->getGarage()->getSettingClass() instanceof SettingClass) {
            $class  = $manager->getRepository(SettingClass::class)->findOneBy(['value' => $event->getClass()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $result = (count($garage));
            $class->setCarsNumber($result);
            $manager->persist($class);
            $manager->flush();
            $manager->clear();
        }
    }
}
