<?php

declare(strict_types=1);

namespace App\Infrastructure\Event\Garage;

use App\Domain\Entity\GarageApp;

final readonly class AppEvent
{
    public function __construct(
        protected GarageApp $garage,
    ) {}

    /**
     * @return GarageApp
     */
    public function getGarage(): GarageApp
    {
        return $this->garage;
    }

    ### Begin::Garage

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->garage->getId();
    }

    /**
     * @return int
     */
    public function getStars(): int
    {
        return $this->garage->getStars();
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->garage->getLevel();
    }

    /**
     * @return int
     */
    public function getEpic(): int
    {
        return $this->garage->getEpic();
    }

    /**
     * @return int
     */
    public function getEvo(): int
    {
        return $this->garage->getEvo();
    }

    /**
     * @return int
     */
    public function getOrderPositionByClass(): int
    {
        return $this->garage->getCarOrder();
    }

    /**
     * @return int
     */
    public function getOrderPositionByStat(): int
    {
        return $this->garage->getStatOrder();
    }

    ### End::Garage

    ### Begin::Garage Blueprint

    /**
     * @return int|string
     */
    public function getBlueprintFirstStar(): int|string
    {
        return $this->garage->getBlueprint()->getStar1();
    }

    /**
     * @return array<string, int>
     */
    public function getBlueprintAllStars(): array
    {
        return [
            'star1' => $this->garage->getBlueprint()->getStar1(),
            'star2' => $this->garage->getBlueprint()->getStar2(),
            'star3' => $this->garage->getBlueprint()->getStar3(),
            'star4' => $this->garage->getBlueprint()->getStar4(),
            'star5' => $this->garage->getBlueprint()->getStar5(),
            'star6' => $this->garage->getBlueprint()->getStar6(),
            'total' => $this->garage->getBlueprint()->getTotal(),
        ];
    }

    ### End::Garage Blueprint

    ### Begin::Garage Stat Max

    /**
     * @return float
     */
    public function getStatMaxSpeed(): float
    {
        return $this->garage->getStatMax()->getSpeed();
    }

    /**
     * @return float
     */
    public function getStatMaxAcceleration(): float
    {
        return $this->garage->getStatMax()->getAcceleration();
    }

    /**
     * @return float
     */
    public function getStatMaxHandling(): float
    {
        return $this->garage->getStatMax()->getHandling();
    }

    /**
     * @return float
     */
    public function getStatMaxNitro(): float
    {
        return $this->garage->getStatMax()->getNitro();
    }

    /**
     * @return float
     */
    public function getStatMaxAverage(): float
    {
        return $this->garage->getStatMax()->getAverage();
    }

    ### End::Garage Stat Max

    ### Begin::Garage Stat Min

    /**
     * @return float
     */
    public function getStatMinSpeed(): float
    {
        return $this->garage->getStatMin()->getSpeed();
    }

    /**
     * @return float
     */
    public function getStatMinAcceleration(): float
    {
        return $this->garage->getStatMin()->getAcceleration();
    }

    /**
     * @return float
     */
    public function getStatMinHandling(): float
    {
        return $this->garage->getStatMin()->getHandling();
    }

    /**
     * @return float
     */
    public function getStatMinNitro(): float
    {
        return $this->garage->getStatMin()->getNitro();
    }

    /**
     * @return float
     */
    public function getStatMinAverage(): float
    {
        return $this->garage->getStatMin()->getAverage();
    }

    ### End::Garage Stat Min

    ### Begin::Garage Upgrade

    /**
     * @return array<string, int>
     */
    public function getUpgrade(): array
    {
        return [
            'speed'        => $this->garage->getUpgrade()->getSpeed(),
            'acceleration' => $this->garage->getUpgrade()->getAcceleration(),
            'handling'     => $this->garage->getUpgrade()->getHandling(),
            'nitro'        => $this->garage->getUpgrade()->getNitro(),
            'common'       => $this->garage->getUpgrade()->getCommon(),
            'rare'         => $this->garage->getUpgrade()->getRare(),
            'epic'         => $this->garage->getUpgrade()->getEpic(),
        ];
    }

    ### End::Garage Upgrade

    ### Begin::Setting Blueprint

    /**
     * @return int|string
     */
    public function getSettingFirstStar(): int|string
    {
        return $this->garage->getSettingBlueprint()->getStar1();
    }

    /**
     * @return array<string, int>
     */
    public function getSettingAllStars(): array
    {
        return [
            'star1' => $this->garage->getSettingBlueprint()->getStar1(),
            'star2' => $this->garage->getSettingBlueprint()->getStar2(),
            'star3' => $this->garage->getSettingBlueprint()->getStar3(),
            'star4' => $this->garage->getSettingBlueprint()->getStar4(),
            'star5' => $this->garage->getSettingBlueprint()->getStar5(),
            'star6' => $this->garage->getSettingBlueprint()->getStar6(),
            'total' => $this->garage->getSettingBlueprint()->getTotal(),
        ];
    }

    ### End::Setting Blueprint

    ### Begin::Setting Class

    /**
     * @return int
     */
    public function getMedian(): int
    {
        return $this->garage->getSettingClass()->getMedian();
    }

    /**
     * @return int
     */
    public function getCarNumberByClass(): int
    {
        return $this->garage->getSettingClass()->getCarsNumber();
    }

    ### End::Setting Class

    ### Begin::Setting Level

    /**
     * @return array<string, int>
     */
    public function getSettingUpgrades(): array
    {
        return [
            'level'  => $this->garage->getSettingLevel()->getLevel(),
            'common' => $this->garage->getSettingLevel()->getCommon(),
            'rare'   => $this->garage->getSettingLevel()->getRare(),
            'epic'   => $this->garage->getSettingLevel()->getEpic(),
        ];
    }

    ### End::Setting Level

    ### Begin::Setting UnitPrice

    public function getSettingUnitPrices(): array
    {
        return [
            'lvl01'   => $this->garage->getSettingUnitPrice()->getLevel01(),
            'lvl02'   => $this->garage->getSettingUnitPrice()->getLevel02(),
            'lvl03'   => $this->garage->getSettingUnitPrice()->getLevel03(),
            'lvl04'   => $this->garage->getSettingUnitPrice()->getLevel04(),
            'lvl05'   => $this->garage->getSettingUnitPrice()->getLevel05(),
            'lvl06'   => $this->garage->getSettingUnitPrice()->getLevel06(),
            'lvl07'   => $this->garage->getSettingUnitPrice()->getLevel07(),
            'lvl08'   => $this->garage->getSettingUnitPrice()->getLevel08(),
            'lvl09'   => $this->garage->getSettingUnitPrice()->getLevel09(),
            'lvl10'   => $this->garage->getSettingUnitPrice()->getLevel10(),
            'lvl11'   => $this->garage->getSettingUnitPrice()->getLevel11(),
            'lvl12'   => $this->garage->getSettingUnitPrice()->getLevel12(),
            'lvl13'   => $this->garage->getSettingUnitPrice()->getLevel13(),
            'common'  => $this->garage->getSettingUnitPrice()->getCommon(),
            'rare'    => $this->garage->getSettingUnitPrice()->getRare(),
            'epic'    => $this->garage->getSettingUnitPrice()->getEpic(),
        ];
    }

    public function getSettingUnitPriceLevel01(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel01();
    }

    public function getSettingUnitPriceLevel02(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel02();
    }

    public function getSettingUnitPriceLevel03(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel03();
    }

    public function getSettingUnitPriceLevel04(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel04();
    }

    public function getSettingUnitPriceLevel05(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel05();
    }

    public function getSettingUnitPriceLevel06(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel06();
    }

    public function getSettingUnitPriceLevel07(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel07();
    }

    public function getSettingUnitPriceLevel08(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel08();
    }

    public function getSettingUnitPriceLevel09(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel09();
    }

    public function getSettingUnitPriceLevel10(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel10();
    }

    public function getSettingUnitPriceLevel11(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel11();
    }

    public function getSettingUnitPriceLevel12(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel12();
    }

    public function getSettingUnitPriceLevel13(): int
    {
        return $this->garage->getSettingUnitPrice()->getLevel13();
    }

    public function getSettingUnitPriceCommon(): int
    {
        return $this->garage->getSettingUnitPrice()->getCommon();
    }

    public function getSettingUnitPriceRare(): int
    {
        return $this->garage->getSettingUnitPrice()->getRare();
    }

    public function getSettingUnitPriceEpic(): int
    {
        return $this->garage->getSettingUnitPrice()->getEpic();
    }

    ### End::Setting UnitPrice
}
