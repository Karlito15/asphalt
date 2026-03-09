<?php

declare(strict_types=1);

namespace App\Service\Event\Setting;

use App\Event\Setting\BrandEvent;
use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use Doctrine\ORM\EntityManagerInterface;

final class BrandService
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
        if ($event->getGarage()->getSettingBrand() instanceof SettingBrand) {
            $brand  = $manager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getName()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingBrand' => $brand]);
            $result = (count($garage));
            $brand->setCarsNumber($result);
        }
    }
}
