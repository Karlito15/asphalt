<?php

declare(strict_types=1);

namespace App\Application\DTO\Search;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;

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
