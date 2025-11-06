<?php

declare(strict_types=1);

namespace App\DTO\Search;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;

class GarageDTO
{
    /** @var GarageApp|null */
    public ?GarageApp $gameUpdate = null;

    /** @var SettingBrand|null */
    public ?SettingBrand $brand = null;

    /**  @var SettingClass|null */
    public ?SettingClass $classLetter = null;

    /** @var bool|null */
    public ?bool $unblock = null;

    /** @var bool|null */
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
