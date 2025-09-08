<?php

namespace App\DTO;

use App\Entity\SettingBrand;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class SearchGarageDTO
{
//    #[ORM\Column(type: 'integer', nullable: true)]
//    #[Assert\PositiveOrZero]
//    #[Assert\Range(min: 0, max: 99)]
//    private ?int $gameUpdate = null;

    #[Assert\Length(min: 1, max: 8)]
    private ?string $classLetter = null;

//    #[Assert\Length(min: 1, max: 64)]
//    private ?SettingBrand $brand = null;

//    #[Assert\Length(min: 1, max: 64)]
//    private ?string $model = null;

    private ?bool $locked = null;

    private ?bool $gold = null;

//    public function getGameUpdate(): ?int
//    {
//        return $this->gameUpdate;
//    }
//
//    public function setGameUpdate(int $gameUpdate): SearchGarageDTO
//    {
//        $this->gameUpdate = $gameUpdate;
//        return $this;
//    }
//
    public function getClassLetter(): ?string
    {
        return $this->classLetter;
    }

    public function setClassLetter(string $classLetter): SearchGarageDTO
    {
        $this->classLetter = $classLetter;
        return $this;
    }

//    public function getBrand(): ?string
//    {
//        return $this->brand;
//    }
//
//    public function setBrand(string $brand): SearchGarageDTO
//    {
//        $this->brand = $brand;
//        return $this;
//    }
//
//    public function getModel(): ?string
//    {
//        return $this->model;
//    }
//
//    public function setModel(string $model): SearchGarageDTO
//    {
//        $this->model = $model;
//        return $this;
//    }

    public function isLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(?bool $locked): SearchGarageDTO
    {
        $this->locked = $locked;
        return $this;
    }

    public function isGold(): ?bool
    {
        return $this->gold;
    }

    public function setGold(?bool $gold): SearchGarageDTO
    {
        $this->gold = $gold;
        return $this;
    }
}
