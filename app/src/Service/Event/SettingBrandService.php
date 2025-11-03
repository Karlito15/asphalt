<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Event\Setting\BrandEvent;
use Doctrine\ORM\EntityManagerInterface;

class SettingBrandService
{
    /**
     * Compte le nombre de voitures par Marque
     * Met à jour une entité SettingBrand
     *
     * @param BrandEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function countCarsByBrand(BrandEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->garage->getSettingBrand() instanceof SettingBrand) {
            $brand  = $manager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getName()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingBrand' => $brand]);
            $result = (count($garage));
            $brand->setCarsNumber($result);
            $manager->persist($brand);
            $manager->flush();
        }
    }
}
