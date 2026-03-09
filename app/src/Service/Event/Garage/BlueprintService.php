<?php

declare(strict_types=1);

namespace App\Service\Event\Garage;

use App\Event\Garage\AppUpdateEvent;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\SettingBlueprint;

class BlueprintService
{
    /**
     * Met à jour les champs GarageStatusControl
     *
     * @param AppUpdateEvent $event
     * @return void
     */
    public function updateStars(AppUpdateEvent $event): void
    {
        // Get Garage
        $garage = $event->garage;

        // Get Star
        $star = $garage->getStars();

        // Get Entities
        $blueprint = $event->getBlueprint();
        $setting   = $event->getSettingBlueprint();

        switch ($star) :
            case 6:
                $event->getStatusControl()->setFullStar1(self::star1($blueprint, $setting));
                $event->getStatusControl()->setFullStar2(self::star2($blueprint, $setting));
                $event->getStatusControl()->setFullStar3(self::star3($blueprint, $setting));
                $event->getStatusControl()->setFullStar4(self::star4($blueprint, $setting));
                $event->getStatusControl()->setFullStar5(self::star5($blueprint, $setting));
                $event->getStatusControl()->setFullStar6(self::star6($blueprint, $setting));
                break;
            case 5:
                $event->getStatusControl()->setFullStar1(self::star1($blueprint, $setting));
                $event->getStatusControl()->setFullStar2(self::star2($blueprint, $setting));
                $event->getStatusControl()->setFullStar3(self::star3($blueprint, $setting));
                $event->getStatusControl()->setFullStar4(self::star4($blueprint, $setting));
                $event->getStatusControl()->setFullStar5(self::star5($blueprint, $setting));
                break;
            case 4:
                $event->getStatusControl()->setFullStar1(self::star1($blueprint, $setting));
                $event->getStatusControl()->setFullStar2(self::star2($blueprint, $setting));
                $event->getStatusControl()->setFullStar3(self::star3($blueprint, $setting));
                $event->getStatusControl()->setFullStar4(self::star4($blueprint, $setting));
                break;
            case 3:
                $event->getStatusControl()->setFullStar1(self::star1($blueprint, $setting));
                $event->getStatusControl()->setFullStar2(self::star2($blueprint, $setting));
                $event->getStatusControl()->setFullStar3(self::star3($blueprint, $setting));
                break;
        endswitch;
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star1(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar1() === $target->getStar1();
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star2(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar2() === $target->getStar2();
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star3(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar3() === $target->getStar3();
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star4(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar4() === $target->getStar4();
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star5(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar5() === $target->getStar5();
    }

    /**
     * Compare les valeurs du Garage avec celle des Settings
     *
     * @param GarageBlueprint $value
     * @param SettingBlueprint $target
     * @return bool
     */
    private static function star6(GarageBlueprint $value, SettingBlueprint $target): bool
    {
        return $value->getStar6() === $target->getStar6();
    }
}
