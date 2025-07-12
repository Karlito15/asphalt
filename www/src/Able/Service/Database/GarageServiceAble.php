<?php

namespace App\Able\Service\Database;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;

trait GarageServiceAble
{
    /**
     * @param string $brand
     * @param string $model
     * @return GarageApp
     */
    private function findGarage(string $brand, string $model): GarageApp
    {
        /** @var SettingBrand $brandEntity */
        $brandEntity = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $brand]);
        /** @var GarageApp $garage */
        $garage      = $this->entityManager->getRepository(GarageApp::class)->findOneBy(['model' => $model, 'settingBrand' => $brandEntity]);
        if (is_null($garage)) {
            echo ' /!\ ' . $brand . ' ' . $model . ' /!\ ';
            exit();
        }

        return $garage;
    }

    /**
     * @param string|null $value
     * @return int
     */
    private function convertStringToInteger(?string $value = null): int
    {
        return ($value === null) ? 0 : (int) $value;
    }
}
