<?php

namespace App\Service\Sheet;

use App\Entity\GarageApp;
use App\Trait\Service\File\DirectoryTrait;
use App\Trait\Service\File\YAMLTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

class GarageService
{
    use DirectoryTrait;
    use YAMLTrait;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
    ) {}

    /**
     * @param GarageApp $garage
     * @return void
     */
    public function create(GarageApp $garage): void
    {
        // Make Folder
        $dir = $this->makeFolder();

        // Get Information
        $info = $this->getInformation($garage);

        // Generate YAML
        self::writeFile($dir . $info['Slug'] . '.yaml', $info);
    }

    /**
     * @return string
     */
    private function makeFolder(): string
    {
        $fs         = new Filesystem();
        $yamlDir    = $this->getYAMLDir();
        $garageDir  = Path::normalize($yamlDir . 'sheets' . DIRECTORY_SEPARATOR . 'garage' . DIRECTORY_SEPARATOR);

        if (false === $fs->exists($garageDir)) {
            $fs->mkdir($garageDir);
        }

        return $garageDir;
    }

    /**
     * @param GarageApp $garage
     * @return array
     */
    private function getInformation(GarageApp $garage): array
    {
        $star                      = $garage->getStars();
        // Blueprints
        $garageBlueprint           = $garage->getBlueprint()->getValues();
        $garageBlueprint1          = $garageBlueprint[0]->getStar1();
        $garageBlueprint2          = $garageBlueprint[0]->getStar2();
        $garageBlueprint3          = $garageBlueprint[0]->getStar3();
        $garageBlueprint4          = $garageBlueprint[0]->getStar4();
        $garageBlueprint5          = $garageBlueprint[0]->getStar5();
        $garageBlueprint6          = $garageBlueprint[0]->getStar6();
        // Ranks
        $garageRank                = $garage->getRank()->getValues();
        // Stats
        $garageStatMax             = $garage->getStatMax()->getValues();
        $garageStatMin             = $garage->getStatMin()->getValues();
        // Upgrades
        $garageUpgrade             = $garage->getUpgrade()->getValues();
        $garageUpgradeSpeed        = $garageUpgrade[0]->getSpeed();
        $garageUpgradeAcceleration = $garageUpgrade[0]->getAcceleration();
        $garageUpgradeHandly       = $garageUpgrade[0]->getHandling();
        $garageUpgradeNitro        = $garageUpgrade[0]->getNitro();
        $garageUpgradeCommon       = $garageUpgrade[0]->getCommon();
        $garageUpgradeRare         = $garageUpgrade[0]->getRare();
        $garageUpgradeEpic         = $garageUpgrade[0]->getEpic();
        // Blueprint
        $settingBLueprint1         = $garage->getSettingBlueprint()->getStar1();
        $settingBLueprint2         = $garage->getSettingBlueprint()->getStar2();
        $settingBLueprint3         = $garage->getSettingBlueprint()->getStar3();
        $settingBLueprint4         = $garage->getSettingBlueprint()->getStar4();
        $settingBLueprint5         = $garage->getSettingBlueprint()->getStar5();
        $settingBLueprint6         = $garage->getSettingBlueprint()->getStar6();
        // Class
        $classTotalCar             = $garage->getSettingClass()->getCarsNumber();
        // Level
        $settingLevelMax           = $garage->getSettingLevel()->getLevel();
        $settingLevelCommon        = $garage->getSettingLevel()->getCommon();
        $settingLevelRare          = $garage->getSettingLevel()->getRare();
        $settingLevelEpic          = $garage->getSettingLevel()->getEpic();
        // Unit Price
        $priceLvl1                 = $garage->getSettingUnitPrice()->getLevel01();
        $priceLvl2                 = $garage->getSettingUnitPrice()->getLevel02();
        $priceLvl3                 = $garage->getSettingUnitPrice()->getLevel03();
        $priceLvl4                 = $garage->getSettingUnitPrice()->getLevel04();
        $priceLvl5                 = $garage->getSettingUnitPrice()->getLevel05();
        $priceLvl6                 = $garage->getSettingUnitPrice()->getLevel06();
        $priceLvl7                 = $garage->getSettingUnitPrice()->getLevel07();
        $priceLvl8                 = $garage->getSettingUnitPrice()->getLevel08();
        $priceLvl9                 = $garage->getSettingUnitPrice()->getLevel09();
        $priceLvl10                = $garage->getSettingUnitPrice()->getLevel10();
        $priceLvl11                = $garage->getSettingUnitPrice()->getLevel11();
        $priceLvl12                = $garage->getSettingUnitPrice()->getLevel12();
        $priceLvl13                = $garage->getSettingUnitPrice()->getLevel13();
        $priceCommon               = $garage->getSettingUnitPrice()->getCommon();
        $priceRare                 = $garage->getSettingUnitPrice()->getRare();
        $priceEpic                 = $garage->getSettingUnitPrice()->getEpic();

        return [
            'Car Name'    => $garage->getSettingBrand()->getName() . " " . $garage->getModel(),
            'Slug'        => $garage->getSlug(),
            'Brand'       => $garage->getSettingBrand()->getName(),
            'Model'       => $garage->getModel(),
            'Class'       => $garage->getSettingClass()->getValue(),
            'Game Update' => $garage->getGameUpdate(),
            'Stars'       => $star,
            'Unlocked'    => $garage->isUnlocked(),
            'Golded'      => $garage->isGold(),
            'Orders'      => [
                'Car'  => $garage->getCarOrder() . '/' . $classTotalCar,
                'Stat' => $garage->getStatOrder() . '/' . $classTotalCar
            ],
            'Level'       => $garage->getLevel() . '/' . $settingLevelMax,
            'Commmon'     => $garageUpgradeCommon . '/' . $settingLevelCommon,
            'Rare'        => $garageUpgradeRare . '/' . $settingLevelRare,
            'Epic'        => $garage->getEpic() . '/' . $settingLevelEpic,
            // Blueprints
            'Blueprint 1 Star'      => $garageBlueprint1,
            'Blueprint 1 Setting'   => $settingBLueprint1,
            'Blueprint 1'           => self::calcBlueprint($garageBlueprint1, $settingBLueprint1),
            'Blueprint 2 Star'      => $garageBlueprint2,
            'Blueprint 2 Setting'   => $settingBLueprint2,
            'Blueprint 2'           => self::calcBlueprint($garageBlueprint2, $settingBLueprint2),
            'Blueprint 3 Star'      => $garageBlueprint3,
            'Blueprint 3 Setting'   => $settingBLueprint3,
            'Blueprint 3'           => self::calcBlueprint($garageBlueprint3, $settingBLueprint3),
            'Blueprint 4 Star'      => $garageBlueprint4,
            'Blueprint 4 Setting'   => $settingBLueprint4,
            'Blueprint 4'           => self::calcBlueprint($garageBlueprint4, $settingBLueprint4),
            'Blueprint 5 Star'      => $garageBlueprint5,
            'Blueprint 5 Setting'   => $settingBLueprint5,
            'Blueprint 5'           => self::calcBlueprint($garageBlueprint5, $settingBLueprint5),
            'Blueprint 6 Star'      => $garageBlueprint6,
            'Blueprint 6 Setting'   => $settingBLueprint6,
            'Blueprint 6'           => self::calcBlueprint($garageBlueprint6, $settingBLueprint6),
            // Ranks
            'Rank Start'            => $garageRank[0]->getStar0(),
            'Rank Star 1'           => $garageRank[0]->getStar1(),
            'Rank Star 2'           => $garageRank[0]->getStar2(),
            'Rank Star 3'           => $garageRank[0]->getStar3(),
            'Rank Star 4'           => $garageRank[0]->getStar4(),
            'Rank Star 5'           => $garageRank[0]->getStar5(),
            'Rank Star 6'           => $garageRank[0]->getStar6(),
            // Stats
            'Stat Min Speed'        => $garageStatMin[0]->getSpeed(),
            'Stat Max Speed'        => $garageStatMax[0]->getSpeed(),
            'Stat Min Acceleration' => $garageStatMin[0]->getAcceleration(),
            'Stat Max Acceleration' => $garageStatMax[0]->getAcceleration(),
            'Stat Min Handly'       => $garageStatMin[0]->getHandling(),
            'Stat Max Handly'       => $garageStatMax[0]->getHandling(),
            'Stat Min Nitro'        => $garageStatMin[0]->getNitro(),
            'Stat Max Nitro'        => $garageStatMax[0]->getNitro(),
            'Stat Min Average'      => $garageStatMin[0]->getAverage(),
            'Stat Max Average'      => $garageStatMax[0]->getAverage(),
            // Prices
//            'Actual Price Lvl 1'     => ($priceLvl1 * $garageUpgradeSpeed) + ($priceLvl1 * $garageUpgradeAcceleration) + ($priceLvl1 * $garageUpgradeHandly) + ($priceLvl1 * $garageUpgradeNitro),
//            'Actual Price Lvl 2'     => ($priceLvl2 * $garageUpgradeSpeed) + ($priceLvl2 * $garageUpgradeAcceleration) + ($priceLvl2 * $garageUpgradeHandly) + ($priceLvl2 * $garageUpgradeNitro),
//            'Actual Price Lvl 3'     => ($priceLvl3 * $garageUpgradeSpeed) + ($priceLvl3 * $garageUpgradeAcceleration) + ($priceLvl3 * $garageUpgradeHandly) + ($priceLvl3 * $garageUpgradeNitro),
//            'Actual Price Lvl 4'     => ($priceLvl4 * $garageUpgradeSpeed) + ($priceLvl4 * $garageUpgradeAcceleration) + ($priceLvl4 * $garageUpgradeHandly) + ($priceLvl4 * $garageUpgradeNitro),
//            'Actual Price Lvl 5'     => ($priceLvl5 * $garageUpgradeSpeed) + ($priceLvl5 * $garageUpgradeAcceleration) + ($priceLvl5 * $garageUpgradeHandly) + ($priceLvl5 * $garageUpgradeNitro),
//            'Actual Price Lvl 6'     => ($priceLvl6 * $garageUpgradeSpeed) + ($priceLvl6 * $garageUpgradeAcceleration) + ($priceLvl6 * $garageUpgradeHandly) + ($priceLvl6 * $garageUpgradeNitro),
//            'Actual Price Lvl 7'     => ($priceLvl7 * $garageUpgradeSpeed) + ($priceLvl7 * $garageUpgradeAcceleration) + ($priceLvl7 * $garageUpgradeHandly) + ($priceLvl7 * $garageUpgradeNitro),
//            'Actual Price Lvl 8'     => ($priceLvl8 * $garageUpgradeSpeed) + ($priceLvl8 * $garageUpgradeAcceleration) + ($priceLvl8 * $garageUpgradeHandly) + ($priceLvl8 * $garageUpgradeNitro),
//            'Actual Price Lvl 9'     => ($priceLvl9 * $garageUpgradeSpeed) + ($priceLvl9 * $garageUpgradeAcceleration) + ($priceLvl9 * $garageUpgradeHandly) + ($priceLvl9 * $garageUpgradeNitro),
//            'Actual Price Lvl 10'    => ($priceLvl10 * $garageUpgradeSpeed) + ($priceLvl10 * $garageUpgradeAcceleration) + ($priceLvl10 * $garageUpgradeHandly) + ($priceLvl10 * $garageUpgradeNitro),
//            'Actual Price Lvl 11'    => ($priceLvl11 * $garageUpgradeSpeed) + ($priceLvl11 * $garageUpgradeAcceleration) + ($priceLvl11 * $garageUpgradeHandly) + ($priceLvl11 * $garageUpgradeNitro),
//            'Actual Price Lvl 12'    => ($priceLvl12 * $garageUpgradeSpeed) + ($priceLvl12 * $garageUpgradeAcceleration) + ($priceLvl12 * $garageUpgradeHandly) + ($priceLvl12 * $garageUpgradeNitro),
//            'Actual Price Lvl 13'    => ($priceLvl13 * $garageUpgradeSpeed) + ($priceLvl13 * $garageUpgradeAcceleration) + ($priceLvl13 * $garageUpgradeHandly) + ($priceLvl13 * $garageUpgradeNitro),
//            'Actual Price Common'    => ($priceCommon * $garageUpgradeCommon),
//            'Actual Price Rare'      => ($priceRare * $garageUpgradeRare),
//            'Actual Price Epic'      => ($priceEpic * $garageUpgradeEpic),
//            'Prevision Price Lvl 1'  => ($priceLvl1 * 4),
//            'Prevision Price Lvl 2'  => ($priceLvl2 * 4),
//            'Prevision Price Lvl 3'  => ($priceLvl3 * 4),
//            'Prevision Price Lvl 4'  => ($priceLvl4 * 4),
//            'Prevision Price Lvl 5'  => ($priceLvl5 * 4),
//            'Prevision Price Lvl 6'  => ($priceLvl6 * 4),
//            'Prevision Price Lvl 7'  => ($priceLvl7 * 4),
//            'Prevision Price Lvl 8'  => ($priceLvl8 * 4),
//            'Prevision Price Lvl 9'  => ($priceLvl9 * 4),
//            'Prevision Price Lvl 10' => ($priceLvl10 * 4),
//            'Prevision Price Lvl 11' => ($priceLvl11 * 4),
//            'Prevision Price Lvl 12' => ($priceLvl12 * 4),
//            'Prevision Price Lvl 13' => ($priceLvl13 * 4),
//            'Prevision Price Common' => ($priceCommon * $garageUpgradeCommon),
//            'Prevision Price Rare'   => ($priceRare * $garageUpgradeRare),
//            'Prevision Price Epic'   => ($priceEpic * $garageUpgradeEpic),
//            'Max Price Lvl 1'        => ($priceLvl1 * 4),
//            'Max Price Lvl 2'        => ($priceLvl2 * 4),
//            'Max Price Lvl 3'        => ($priceLvl3 * 4),
//            'Max Price Lvl 4'        => ($priceLvl4 * 4),
//            'Max Price Lvl 5'        => ($priceLvl5 * 4),
//            'Max Price Lvl 6'        => ($priceLvl6 * 4),
//            'Max Price Lvl 7'        => ($priceLvl7 * 4),
//            'Max Price Lvl 8'        => ($priceLvl8 * 4),
//            'Max Price Lvl 9'        => ($priceLvl9 * 4),
//            'Max Price Lvl 10'       => ($priceLvl10 * 4),
//            'Max Price Lvl 11'       => ($priceLvl11 * 4),
//            'Max Price Lvl 12'       => ($priceLvl12 * 4),
//            'Max Price Lvl 13'       => ($priceLvl13 * 4),
//            'Max Price Common'       => ($priceCommon * $settingLevelCommon),
//            'Max Price Rare'         => ($priceRare * $settingLevelRare),
//            'Max Price Epic'         => ($priceEpic * $settingLevelEpic),
        ];
    }

    private static function calcBlueprint(int|string $my, int|string $target): int
    {
        // Int
        if (is_int($my) && is_int($target)) {
            return $target - $my;
        }

        // String (Key)
        if (is_string($my) && is_string($target)) {
            if ($target === $my) {
                return 1;
            }
            return 0;
        }

        // Null
        if (is_null($my) && is_null($target)) {
            return 0;
        }
    }

//    private function calcRealPrice(int $level): int
//    {
//
//    }
//
//    private function calcPrevisionPrice(): int
//    {
//
//    }
}
