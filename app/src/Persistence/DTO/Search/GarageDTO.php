<?php

declare(strict_types=1);

namespace App\Persistence\DTO\Search;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;

class GarageDTO
{
    public ?GarageApp $gameUpdate = null;

    public ?SettingBrand $brand = null;

    public ?SettingClass $classLetter = null;

    public ?bool $unblock = null;

    public ?bool $gold = null;

    /**
     * @return GarageApp|null
     */
    public function getGameUpdate(): ?GarageApp
    {
        if ($this->gameUpdate instanceof GarageApp) {
            return $this->gameUpdate;
        }

        return null;
    }

    /**
     * @return SettingBrand|null
     */
    public function getBrand(): ?SettingBrand
    {
        if ($this->brand instanceof SettingBrand) {
            return $this->brand;
        }

        return null;
    }

    /**
     * @return SettingClass|null
     */
    public function getClassLetter(): ?SettingClass
    {
        if ($this->classLetter instanceof SettingClass) {
            return $this->classLetter;
        }

        return null;
    }

    /**
     * @return bool|null
     */
    public function isUnbLock(): ?bool
    {
        return $this->unblock;
    }

    /**
     * @return bool|null
     */
    public function isGold(): ?bool
    {
        return $this->gold;
    }
}
