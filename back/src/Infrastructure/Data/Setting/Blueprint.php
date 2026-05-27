<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingBlueprint;

class Blueprint
{
    public static function create(array $datas): SettingBlueprint
    {
        $entity = new SettingBlueprint();
        self::setter($entity, $datas);

        return $entity;
    }

    public static function update(SettingBlueprint $entity, array $datas): SettingBlueprint
    {
        self::setter($entity, $datas);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param SettingBlueprint $entity
     * @param array $datas
     * @return void
     */
    private static function setter(SettingBlueprint $entity, array $datas): void
    {
        $entity->setStar1($datas['Star1']);
        $entity->setStar2((int) $datas['Star2']);
        $entity->setStar3((int) $datas['Star3']);
        $entity->setStar4((int) $datas['Star4']);
        $entity->setStar5((int) $datas['Star5']);
        $entity->setStar6((int) $datas['Star6']);
    }
}
