<?php

declare(strict_types=1);

namespace App\Trait\Service\Database;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use RuntimeException;

trait GarageServiceTrait
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

        return is_null($garage) ? throw new RuntimeException(' /!\ ' . $brand . ' ' . $model . ' /!\ ') : $garage;
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
