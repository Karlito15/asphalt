<?php

declare(strict_types=1);

namespace App\Application\Service\Event\Setting;

use App\Application\Event\Setting\BrandEvent;
use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use Doctrine\ORM\EntityManagerInterface;

final readonly class CountCarEventByBrand
{
    /**
     * Compte le nombre de voitures par Marque
     * Met à jour l'entité SettingBrand
     *
     * @param BrandEvent $event
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function countCarsByBrand(BrandEvent $event, EntityManagerInterface $manager): void
    {
        if ($event->getGarage()->getSettingBrand() instanceof SettingBrand) {
            $brand  = $manager->getRepository(SettingBrand::class)->findOneBy(['name' => $event->getBrand()]);
            $garage = $manager->getRepository(GarageApp::class)->findBy(['settingBrand' => $brand]);
            $result = (count($garage));
            $brand->setCarsNumber($result);
            $manager->persist($brand);
            $manager->flush();
        }
    }
}
