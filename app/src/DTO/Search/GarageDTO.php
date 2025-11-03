<?php

declare(strict_types=1);

namespace App\DTO\Search;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;

class GarageDTO
{
    /** @var GarageApp|null */
    public ?GarageApp $garage = null;

    /** @var SettingBrand|null */
    public ?SettingBrand $brand = null;

    /**  @var string|null */
    public ?string $classLetter = null;

    /** @var bool|null */
    public ?bool $unlocked = null;

    /** @var bool|null */
    public ?bool $gold = null;

    /** @var string|null */
    public ?string $order = null;

    public function getGameUpdate(): ?GarageApp
    {
        if ($this->garage instanceof GarageApp) {
            return $this->garage;
        }

        return null;
    }

    public function setGameUpdate(GarageApp $garage): GarageDTO
    {
        $this->garage = $garage;

        return $this;
    }

    public function getBrand(): ?SettingBrand
    {
        return $this->brand;
    }

    public function setBrand(?SettingBrand $brand): GarageDTO
    {
        $this->brand = $brand;

        return $this;
    }

    public function getClassLetter(): ?string
    {
        return $this->classLetter;
    }

    public function isLocked(): ?bool
    {
        return $this->unlocked;
    }

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOrder(?string $order): void
    {
        $this->order = $order;
    }
}
