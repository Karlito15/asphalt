<?php

declare(strict_types=1);

namespace App\Persistence\DTO\Command;

class GarageDTO
{
    public int $id;

    public int $stars;

    public int $gameUpdate;

    public int $carOrder;

    public int $statOrder;

    public int $level;

    public int $epic;

    public int $evo;

    public string $model;

    public string $slug;

    public int|string $garageBlueprintStar1;

    public int $garageBlueprintStar2;

    public int $garageBlueprintStar3;

    public int $garageBlueprintStar4;

    public int $garageBlueprintStar5;

    public int $garageBlueprintStar6;

    public int $garageBlueprintTotal;

    public int $garageGauntletSpeed;

    public int $garageGauntletAcceleration;

    public int $garageGauntletHandling;

    public int $garageGauntletNitro;

    public int $garageGauntletMark;

    public int $garageGauntletDivision;

    public int $garageRankStar0;

    public int $garageRankStar1;

    public int $garageRankStar2;

    public int $garageRankStar3;

    public int $garageRankStar4;

    public int $garageRankStar5;

    public int $garageRankStar6;

    public float $garageStatActualSpeed;

    public float $garageStatActualAcceleration;

    public float $garageStatActualHandling;

    public float $garageStatActualNitro;

    public float $garageStatActualAverage;

    public float $garageStatMaxSpeed;

    public float $garageStatMaxAcceleration;

    public float $garageStatMaxHandling;

    public float $garageStatMaxNitro;

    public float $garageStatMaxAverage;

    public float $garageStatMinSpeed;

    public float $garageStatMinAcceleration;

    public float $garageStatMinHandling;

    public float $garageStatMinNitro;

    public float $garageStatMinAverage;

    public int $garageUpgradeSpeed;

    public int $garageUpgradeAcceleration;

    public int $garageUpgradeHandling;

    public int $garageUpgradeNitro;

    public int $garageUpgradeCommon;

    public int $garageUpgradeRare;

    public int $garageUpgradeEpic;

    public int|string $settingBlueprintStar1;

    public int $settingBlueprintStar2;

    public int $settingBlueprintStar3;

    public int $settingBlueprintStar4;

    public int $settingBlueprintStar5;

    public int $settingBlueprintStar6;

    public int $settingBlueprintTotal;

    public string $settingBrandName;

    public string $settingClassValue;

    public int $settingClassNumber;

    public int $settingClassMedian;

    public int $settingLevelLevel;

    public int $settingLevelCommon;

    public int $settingLevelRare;

    public int $settingLevelEpic;

    public int $settingUnitPriceLevel01;

    public int $settingUnitPriceLevel02;

    public int $settingUnitPriceLevel03;

    public int $settingUnitPriceLevel04;

    public int $settingUnitPriceLevel05;

    public int $settingUnitPriceLevel06;

    public int $settingUnitPriceLevel07;

    public int $settingUnitPriceLevel08;

    public int $settingUnitPriceLevel09;

    public int $settingUnitPriceLevel10;

    public int|null $settingUnitPriceLevel11;

    public int|null $settingUnitPriceLevel12;

    public int|null $settingUnitPriceLevel13;

    public int $settingUnitPriceCommon;

    public int $settingUnitPriceRare;

    public int|null $settingUnitPriceEpic;

    public function __toString(): string
    {
        return $this->getSettingBrandName() . ' ' . $this->getModel();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): static
    {
        $this->stars = $stars;

        return $this;
    }

    public function getGameUpdate(): int
    {
        return $this->gameUpdate;
    }

    public function setGameUpdate(int $gameUpdate): static
    {
        $this->gameUpdate = $gameUpdate;

        return $this;
    }

    public function getCarOrder(): int
    {
        return $this->carOrder;
    }

    public function setCarOrder(int $carOrder): static
    {
        $this->carOrder = $carOrder;

        return $this;
    }

    public function getStatOrder(): int
    {
        return $this->statOrder;
    }

    public function setStatOrder(int $statOrder): static
    {
        $this->statOrder = $statOrder;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getEpic(): int
    {
        return $this->epic;
    }

    public function setEpic(int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }

    public function getEvo(): int
    {
        return $this->evo;
    }

    public function setEvo(int $evo): static
    {
        $this->evo = $evo;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGarageBlueprintStar1(): int|string
    {
        return $this->garageBlueprintStar1;
    }

    public function setGarageBlueprintStar1(int|string $garageBlueprintStar1): static
    {
        $this->garageBlueprintStar1 = $garageBlueprintStar1;

        return $this;
    }

    public function getGarageBlueprintStar2(): int
    {
        return $this->garageBlueprintStar2;
    }

    public function setGarageBlueprintStar2(int $garageBlueprintStar2): static
    {
        $this->garageBlueprintStar2 = $garageBlueprintStar2;

        return $this;
    }

    public function getGarageBlueprintStar3(): int
    {
        return $this->garageBlueprintStar3;
    }

    public function setGarageBlueprintStar3(int $garageBlueprintStar3): static
    {
        $this->garageBlueprintStar3 = $garageBlueprintStar3;

        return $this;
    }

    public function getGarageBlueprintStar4(): int
    {
        return $this->garageBlueprintStar4;
    }

    public function setGarageBlueprintStar4(int $garageBlueprintStar4): static
    {
        $this->garageBlueprintStar4 = $garageBlueprintStar4;

        return $this;
    }

    public function getGarageBlueprintStar5(): int
    {
        return $this->garageBlueprintStar5;
    }

    public function setGarageBlueprintStar5(int $garageBlueprintStar5): static
    {
        $this->garageBlueprintStar5 = $garageBlueprintStar5;

        return $this;
    }

    public function getGarageBlueprintStar6(): int
    {
        return $this->garageBlueprintStar6;
    }

    public function setGarageBlueprintStar6(int $garageBlueprintStar6): static
    {
        $this->garageBlueprintStar6 = $garageBlueprintStar6;

        return $this;
    }

    public function getGarageBlueprintTotal(): int
    {
        return $this->garageBlueprintTotal;
    }

    public function setGarageBlueprintTotal(int $garageBlueprintTotal): static
    {
        $this->garageBlueprintTotal = $garageBlueprintTotal;

        return $this;
    }

    public function getGarageGauntletSpeed(): int
    {
        return $this->garageGauntletSpeed;
    }

    public function setGarageGauntletSpeed(int $garageGauntletSpeed): static
    {
        $this->garageGauntletSpeed = $garageGauntletSpeed;

        return $this;
    }

    public function getGarageGauntletAcceleration(): int
    {
        return $this->garageGauntletAcceleration;
    }

    public function setGarageGauntletAcceleration(int $garageGauntletAcceleration): static
    {
        $this->garageGauntletAcceleration = $garageGauntletAcceleration;

        return $this;
    }

    public function getGarageGauntletHandling(): int
    {
        return $this->garageGauntletHandling;
    }

    public function setGarageGauntletHandling(int $garageGauntletHandling): static
    {
        $this->garageGauntletHandling = $garageGauntletHandling;

        return $this;
    }

    public function getGarageGauntletNitro(): int
    {
        return $this->garageGauntletNitro;
    }

    public function setGarageGauntletNitro(int $garageGauntletNitro): static
    {
        $this->garageGauntletNitro = $garageGauntletNitro;

        return $this;
    }

    public function getGarageGauntletMark(): int
    {
        return $this->garageGauntletMark;
    }

    public function setGarageGauntletMark(int $garageGauntletMark): static
    {
        $this->garageGauntletMark = $garageGauntletMark;

        return $this;
    }

    public function getGarageGauntletDivision(): int
    {
        return $this->garageGauntletDivision;
    }

    public function setGarageGauntletDivision(int $garageGauntletDivision): static
    {
        $this->garageGauntletDivision = $garageGauntletDivision;

        return $this;
    }

    public function getGarageRankStar0(): int
    {
        return $this->garageRankStar0;
    }

    public function setGarageRankStar0(int $garageRankStar0): static
    {
        $this->garageRankStar0 = $garageRankStar0;

        return $this;
    }

    public function getGarageRankStar1(): int
    {
        return $this->garageRankStar1;
    }

    public function setGarageRankStar1(int $garageRankStar1): static
    {
        $this->garageRankStar1 = $garageRankStar1;

        return $this;
    }

    public function getGarageRankStar2(): int
    {
        return $this->garageRankStar2;
    }

    public function setGarageRankStar2(int $garageRankStar2): static
    {
        $this->garageRankStar2 = $garageRankStar2;

        return $this;
    }

    public function getGarageRankStar3(): int
    {
        return $this->garageRankStar3;
    }

    public function setGarageRankStar3(int $garageRankStar3): static
    {
        $this->garageRankStar3 = $garageRankStar3;

        return $this;
    }

    public function getGarageRankStar4(): int
    {
        return $this->garageRankStar4;
    }

    public function setGarageRankStar4(int $garageRankStar4): static
    {
        $this->garageRankStar4 = $garageRankStar4;

        return $this;
    }

    public function getGarageRankStar5(): int
    {
        return $this->garageRankStar5;
    }

    public function setGarageRankStar5(int $garageRankStar5): static
    {
        $this->garageRankStar5 = $garageRankStar5;

        return $this;
    }

    public function getGarageRankStar6(): int
    {
        return $this->garageRankStar6;
    }

    public function setGarageRankStar6(int $garageRankStar6): static
    {
        $this->garageRankStar6 = $garageRankStar6;

        return $this;
    }

    public function getGarageStatActualSpeed(): float
    {
        return $this->garageStatActualSpeed;
    }

    public function setGarageStatActualSpeed(float $garageStatActualSpeed): static
    {
        $this->garageStatActualSpeed = $garageStatActualSpeed;

        return $this;
    }

    public function getGarageStatActualAcceleration(): float
    {
        return $this->garageStatActualAcceleration;
    }

    public function setGarageStatActualAcceleration(float $garageStatActualAcceleration): static
    {
        $this->garageStatActualAcceleration = $garageStatActualAcceleration;

        return $this;
    }

    public function getGarageStatActualHandling(): float
    {
        return $this->garageStatActualHandling;
    }

    public function setGarageStatActualHandling(float $garageStatActualHandling): static
    {
        $this->garageStatActualHandling = $garageStatActualHandling;

        return $this;
    }

    public function getGarageStatActualNitro(): float
    {
        return $this->garageStatActualNitro;
    }

    public function setGarageStatActualNitro(float $garageStatActualNitro): static
    {
        $this->garageStatActualNitro = $garageStatActualNitro;

        return $this;
    }

    public function getGarageStatActualAverage(): float
    {
        return $this->garageStatActualAverage;
    }

    public function setGarageStatActualAverage(float $garageStatActualAverage): static
    {
        $this->garageStatActualAverage = $garageStatActualAverage;

        return $this;
    }

    public function getGarageStatMaxSpeed(): float
    {
        return $this->garageStatMaxSpeed;
    }

    public function setGarageStatMaxSpeed(float $garageStatMaxSpeed): static
    {
        $this->garageStatMaxSpeed = $garageStatMaxSpeed;

        return $this;
    }

    public function getGarageStatMaxAcceleration(): float
    {
        return $this->garageStatMaxAcceleration;
    }

    public function setGarageStatMaxAcceleration(float $garageStatMaxAcceleration): static
    {
        $this->garageStatMaxAcceleration = $garageStatMaxAcceleration;

        return $this;
    }

    public function getGarageStatMaxHandling(): float
    {
        return $this->garageStatMaxHandling;
    }

    public function setGarageStatMaxHandling(float $garageStatMaxHandling): static
    {
        $this->garageStatMaxHandling = $garageStatMaxHandling;

        return $this;
    }

    public function getGarageStatMaxNitro(): float
    {
        return $this->garageStatMaxNitro;
    }

    public function setGarageStatMaxNitro(float $garageStatMaxNitro): static
    {
        $this->garageStatMaxNitro = $garageStatMaxNitro;

        return $this;
    }

    public function getGarageStatMaxAverage(): float
    {
        return $this->garageStatMaxAverage;
    }

    public function setGarageStatMaxAverage(float $garageStatMaxAverage): static
    {
        $this->garageStatMaxAverage = $garageStatMaxAverage;

        return $this;
    }

    public function getGarageStatMinSpeed(): float
    {
        return $this->garageStatMinSpeed;
    }

    public function setGarageStatMinSpeed(float $garageStatMinSpeed): static
    {
        $this->garageStatMinSpeed = $garageStatMinSpeed;

        return $this;
    }

    public function getGarageStatMinAcceleration(): float
    {
        return $this->garageStatMinAcceleration;
    }

    public function setGarageStatMinAcceleration(float $garageStatMinAcceleration): static
    {
        $this->garageStatMinAcceleration = $garageStatMinAcceleration;

        return $this;
    }

    public function getGarageStatMinHandling(): float
    {
        return $this->garageStatMinHandling;
    }

    public function setGarageStatMinHandling(float $garageStatMinHandling): static
    {
        $this->garageStatMinHandling = $garageStatMinHandling;

        return $this;
    }

    public function getGarageStatMinNitro(): float
    {
        return $this->garageStatMinNitro;
    }

    public function setGarageStatMinNitro(float $garageStatMinNitro): static
    {
        $this->garageStatMinNitro = $garageStatMinNitro;

        return $this;
    }

    public function getGarageStatMinAverage(): float
    {
        return $this->garageStatMinAverage;
    }

    public function setGarageStatMinAverage(float $garageStatMinAverage): static
    {
        $this->garageStatMinAverage = $garageStatMinAverage;

        return $this;
    }

    public function getGarageUpgradeSpeed(): int
    {
        return $this->garageUpgradeSpeed;
    }

    public function setGarageUpgradeSpeed(int $garageUpgradeSpeed): static
    {
        $this->garageUpgradeSpeed = $garageUpgradeSpeed;

        return $this;
    }

    public function getGarageUpgradeAcceleration(): int
    {
        return $this->garageUpgradeAcceleration;
    }

    public function setGarageUpgradeAcceleration(int $garageUpgradeAcceleration): static
    {
        $this->garageUpgradeAcceleration = $garageUpgradeAcceleration;

        return $this;
    }

    public function getGarageUpgradeHandling(): int
    {
        return $this->garageUpgradeHandling;
    }

    public function setGarageUpgradeHandling(int $garageUpgradeHandling): static
    {
        $this->garageUpgradeHandling = $garageUpgradeHandling;

        return $this;
    }

    public function getGarageUpgradeNitro(): int
    {
        return $this->garageUpgradeNitro;
    }

    public function setGarageUpgradeNitro(int $garageUpgradeNitro): static
    {
        $this->garageUpgradeNitro = $garageUpgradeNitro;

        return $this;
    }

    public function getGarageUpgradeCommon(): int
    {
        return $this->garageUpgradeCommon;
    }

    public function setGarageUpgradeCommon(int $garageUpgradeCommon): static
    {
        $this->garageUpgradeCommon = $garageUpgradeCommon;

        return $this;
    }

    public function getGarageUpgradeRare(): int
    {
        return $this->garageUpgradeRare;
    }

    public function setGarageUpgradeRare(int $garageUpgradeRare): static
    {
        $this->garageUpgradeRare = $garageUpgradeRare;

        return $this;
    }

    public function getGarageUpgradeEpic(): int
    {
        return $this->garageUpgradeEpic;
    }

    public function setGarageUpgradeEpic(int $garageUpgradeEpic): static
    {
        $this->garageUpgradeEpic = $garageUpgradeEpic;

        return $this;
    }

    public function getSettingBlueprintStar1(): int|string
    {
        return $this->settingBlueprintStar1;
    }

    public function setSettingBlueprintStar1(int|string $settingBlueprintStar1): static
    {
        $this->settingBlueprintStar1 = $settingBlueprintStar1;

        return $this;
    }

    public function getSettingBlueprintStar2(): int
    {
        return $this->settingBlueprintStar2;
    }

    public function setSettingBlueprintStar2(int $settingBlueprintStar2): static
    {
        $this->settingBlueprintStar2 = $settingBlueprintStar2;

        return $this;
    }

    public function getSettingBlueprintStar3(): int
    {
        return $this->settingBlueprintStar3;
    }

    public function setSettingBlueprintStar3(int $settingBlueprintStar3): static
    {
        $this->settingBlueprintStar3 = $settingBlueprintStar3;

        return $this;
    }

    public function getSettingBlueprintStar4(): int
    {
        return $this->settingBlueprintStar4;
    }

    public function setSettingBlueprintStar4(int $settingBlueprintStar4): static
    {
        $this->settingBlueprintStar4 = $settingBlueprintStar4;

        return $this;
    }

    public function getSettingBlueprintStar5(): int
    {
        return $this->settingBlueprintStar5;
    }

    public function setSettingBlueprintStar5(int $settingBlueprintStar5): static
    {
        $this->settingBlueprintStar5 = $settingBlueprintStar5;

        return $this;
    }

    public function getSettingBlueprintStar6(): int
    {
        return $this->settingBlueprintStar6;
    }

    public function setSettingBlueprintStar6(int $settingBlueprintStar6): static
    {
        $this->settingBlueprintStar6 = $settingBlueprintStar6;

        return $this;
    }

    public function getSettingBlueprintTotal(): int
    {
        return $this->settingBlueprintTotal;
    }

    public function setSettingBlueprintTotal(int $settingBlueprintTotal): static
    {
        $this->settingBlueprintTotal = $settingBlueprintTotal;

        return $this;
    }

    public function getSettingBrandName(): string
    {
        return $this->settingBrandName;
    }

    public function setSettingBrandName(string $settingBrandName): static
    {
        $this->settingBrandName = $settingBrandName;

        return $this;
    }

    public function getSettingClassValue(): string
    {
        return $this->settingClassValue;
    }

    public function setSettingClassValue(string $settingClassValue): static
    {
        $this->settingClassValue = $settingClassValue;

        return $this;
    }

    public function getSettingClassNumber(): int
    {
        return $this->settingClassNumber;
    }

    public function setSettingClassNumber(int $settingClassNumber): static
    {
        $this->settingClassNumber = $settingClassNumber;

        return $this;
    }

    public function getSettingClassMedian(): int
    {
        return $this->settingClassMedian;
    }

    public function setSettingClassMedian(int $settingClassMedian): static
    {
        $this->settingClassMedian = $settingClassMedian;

        return $this;
    }

    public function getSettingLevelLevel(): int
    {
        return $this->settingLevelLevel;
    }

    public function setSettingLevelLevel(int $settingLevelLevel): static
    {
        $this->settingLevelLevel = $settingLevelLevel;

        return $this;
    }

    public function getSettingLevelCommon(): int
    {
        return $this->settingLevelCommon;
    }

    public function setSettingLevelCommon(int $settingLevelCommon): static
    {
        $this->settingLevelCommon = $settingLevelCommon;

        return $this;
    }

    public function getSettingLevelRare(): int
    {
        return $this->settingLevelRare;
    }

    public function setSettingLevelRare(int $settingLevelRare): static
    {
        $this->settingLevelRare = $settingLevelRare;

        return $this;
    }

    public function getSettingLevelEpic(): int
    {
        return $this->settingLevelEpic;
    }

    public function setSettingLevelEpic(int $settingLevelEpic): static
    {
        $this->settingLevelEpic = $settingLevelEpic;

        return $this;
    }

    public function getSettingUnitPriceLevel01(): int
    {
        return $this->settingUnitPriceLevel01;
    }

    public function setSettingUnitPriceLevel01(int $settingUnitPriceLevel01): static
    {
        $this->settingUnitPriceLevel01 = $settingUnitPriceLevel01;

        return $this;
    }

    public function getSettingUnitPriceLevel02(): int
    {
        return $this->settingUnitPriceLevel02;
    }

    public function setSettingUnitPriceLevel02(int $settingUnitPriceLevel02): static
    {
        $this->settingUnitPriceLevel02 = $settingUnitPriceLevel02;

        return $this;
    }

    public function getSettingUnitPriceLevel03(): int
    {
        return $this->settingUnitPriceLevel03;
    }

    public function setSettingUnitPriceLevel03(int $settingUnitPriceLevel03): static
    {
        $this->settingUnitPriceLevel03 = $settingUnitPriceLevel03;

        return $this;
    }

    public function getSettingUnitPriceLevel04(): int
    {
        return $this->settingUnitPriceLevel04;
    }

    public function setSettingUnitPriceLevel04(int $settingUnitPriceLevel04): static
    {
        $this->settingUnitPriceLevel04 = $settingUnitPriceLevel04;

        return $this;
    }

    public function getSettingUnitPriceLevel05(): int
    {
        return $this->settingUnitPriceLevel05;
    }

    public function setSettingUnitPriceLevel05(int $settingUnitPriceLevel05): static
    {
        $this->settingUnitPriceLevel05 = $settingUnitPriceLevel05;

        return $this;
    }

    public function getSettingUnitPriceLevel06(): int
    {
        return $this->settingUnitPriceLevel06;
    }

    public function setSettingUnitPriceLevel06(int $settingUnitPriceLevel06): static
    {
        $this->settingUnitPriceLevel06 = $settingUnitPriceLevel06;

        return $this;
    }

    public function getSettingUnitPriceLevel07(): int
    {
        return $this->settingUnitPriceLevel07;
    }

    public function setSettingUnitPriceLevel07(int $settingUnitPriceLevel07): static
    {
        $this->settingUnitPriceLevel07 = $settingUnitPriceLevel07;

        return $this;
    }

    public function getSettingUnitPriceLevel08(): int
    {
        return $this->settingUnitPriceLevel08;
    }

    public function setSettingUnitPriceLevel08(int $settingUnitPriceLevel08): static
    {
        $this->settingUnitPriceLevel08 = $settingUnitPriceLevel08;

        return $this;
    }

    public function getSettingUnitPriceLevel09(): int
    {
        return $this->settingUnitPriceLevel09;
    }

    public function setSettingUnitPriceLevel09(int $settingUnitPriceLevel09): static
    {
        $this->settingUnitPriceLevel09 = $settingUnitPriceLevel09;

        return $this;
    }

    public function getSettingUnitPriceLevel10(): int
    {
        return $this->settingUnitPriceLevel10;
    }

    public function setSettingUnitPriceLevel10(int $settingUnitPriceLevel10): static
    {
        $this->settingUnitPriceLevel10 = $settingUnitPriceLevel10;

        return $this;
    }

    public function getSettingUnitPriceLevel11(): int|null
    {
        return $this->settingUnitPriceLevel11;
    }

    public function setSettingUnitPriceLevel11(int|null $settingUnitPriceLevel11): static
    {
        $this->settingUnitPriceLevel11 = $settingUnitPriceLevel11;

        return $this;
    }

    public function getSettingUnitPriceLevel12(): int|null
    {
        return $this->settingUnitPriceLevel12;
    }

    public function setSettingUnitPriceLevel12(int|null $settingUnitPriceLevel12): static
    {
        $this->settingUnitPriceLevel12 = $settingUnitPriceLevel12;

        return $this;
    }

    public function getSettingUnitPriceLevel13(): int|null
    {
        return $this->settingUnitPriceLevel13;
    }

    public function setSettingUnitPriceLevel13(int|null $settingUnitPriceLevel13): static
    {
        $this->settingUnitPriceLevel13 = $settingUnitPriceLevel13;

        return $this;
    }

    public function getSettingUnitPriceCommon(): int
    {
        return $this->settingUnitPriceCommon;
    }

    public function setSettingUnitPriceCommon(int $settingUnitPriceCommon): static
    {
        $this->settingUnitPriceCommon = $settingUnitPriceCommon;

        return $this;
    }

    public function getSettingUnitPriceRare(): int
    {
        return $this->settingUnitPriceRare;
    }

    public function setSettingUnitPriceRare(int $settingUnitPriceRare): static
    {
        $this->settingUnitPriceRare = $settingUnitPriceRare;

        return $this;
    }

    public function getSettingUnitPriceEpic(): int|null
    {
        return $this->settingUnitPriceEpic;
    }

    public function setSettingUnitPriceEpic(int|null $settingUnitPriceEpic): static
    {
        $this->settingUnitPriceEpic = $settingUnitPriceEpic;

        return $this;
    }

    public function getSpent(): int
    {
        $upgrades = $this->getSpentUpgrade();
        $commons  = $this->getSpentCommon();
        $rares    = $this->getSpentRare();
        $epics    = $this->getSpentEpic();

        return ($upgrades + $commons + $rares + $epics);
    }

    public function getTotalCost(): int
    {
        $level = $this->getSettingLevelLevel();
        $upgrades = 0;
        $price = [
            1  => $this->getSettingUnitPriceLevel01(),
            2  => $this->getSettingUnitPriceLevel02(),
            3  => $this->getSettingUnitPriceLevel03(),
            4  => $this->getSettingUnitPriceLevel04(),
            5  => $this->getSettingUnitPriceLevel05(),
            6  => $this->getSettingUnitPriceLevel06(),
            7  => $this->getSettingUnitPriceLevel07(),
            8  => $this->getSettingUnitPriceLevel08(),
            9  => $this->getSettingUnitPriceLevel09(),
            10 => $this->getSettingUnitPriceLevel10(),
            11 => $this->getSettingUnitPriceLevel11(),
            12 => $this->getSettingUnitPriceLevel12(),
            13 => $this->getSettingUnitPriceLevel13(),
        ];
        for ($niveau = 1; $niveau <= $level; $niveau++) {
            $upgrades += $price[$niveau];
        }
        $commons  = $this->getSpentCommon(false);
        $rares    = $this->getSpentRare(false);
        $epics    = $this->getSpentEpic(false);

        return (($upgrades * 4) + $commons + $rares + $epics);
    }

    /**
     * Retourne le montant pour les Upgrades
     *
     * @return int
     */
    private function getSpentUpgrade(): int
    {
        $speed = $accel = $hand = $nitro = 0;

        $price = [
            1  => $this->getSettingUnitPriceLevel01(),
            2  => $this->getSettingUnitPriceLevel02(),
            3  => $this->getSettingUnitPriceLevel03(),
            4  => $this->getSettingUnitPriceLevel04(),
            5  => $this->getSettingUnitPriceLevel05(),
            6  => $this->getSettingUnitPriceLevel06(),
            7  => $this->getSettingUnitPriceLevel07(),
            8  => $this->getSettingUnitPriceLevel08(),
            9  => $this->getSettingUnitPriceLevel09(),
            10 => $this->getSettingUnitPriceLevel10(),
            11 => $this->getSettingUnitPriceLevel11(),
            12 => $this->getSettingUnitPriceLevel12(),
            13 => $this->getSettingUnitPriceLevel13(),
        ];

        for ($level = 1; $level <= $this->getGarageUpgradeSpeed(); $level++) {
            $speed += $price[$level];
        }

        for ($level = 1; $level <= $this->getGarageUpgradeAcceleration(); $level++) {
            $accel += $price[$level];
        }

        for ($level = 1; $level <= $this->getGarageUpgradeHandling(); $level++) {
            $hand += $price[$level];
        }

        for ($level = 1; $level <= $this->getGarageUpgradeNitro(); $level++) {
            $nitro += $price[$level];
        }

        return ($speed + $accel + $hand + $nitro);
    }

    /**
     * Retourne le montant pour les Commons
     *
     * @param bool $garage
     * @return int
     */
    private function getSpentCommon(bool $garage = true): int
    {
        if ($garage === false) {
            return $this->getSettingLevelCommon() * $this->getSettingUnitPriceCommon();
        }

        return $this->getGarageUpgradeCommon() * $this->getSettingUnitPriceCommon();
    }

    /**
     * Retourne le montant pour les Rares
     *
     * @param bool $garage
     * @return int
     */
    private function getSpentRare(bool $garage = true): int
    {
        if ($garage === false) {
            return $this->getSettingLevelRare() * $this->getSettingUnitPriceRare();
        }

        return $this->getGarageUpgradeRare() * $this->getSettingUnitPriceRare();
    }

    /**
     * Retourne le montant pour les Epics
     *
     * @param bool $garage
     * @return int
     */
    private function getSpentEpic(bool $garage = true): int
    {
        if ($garage === false) {
            return $this->getSettingLevelEpic() * $this->getSettingUnitPriceEpic();
        }

        return $this->getGarageUpgradeEpic() * $this->getSettingUnitPriceEpic();
    }
}
