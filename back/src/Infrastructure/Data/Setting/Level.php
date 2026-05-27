<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingLevel;

class Level
{
    public static function create(array $datas): SettingLevel
    {
        $entity = new SettingLevel();
        self::setter($entity, $datas);

        return $entity;
    }

    public static function update(SettingLevel $entity, array $datas): SettingLevel
    {
        self::setter($entity, $datas);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param SettingLevel $entity
     * @param array $datas
     * @return void
     */
    private static function setter(SettingLevel $entity, array $datas): void
    {
        $entity->setLevel((int) $datas['Level']);
        $entity->setCommon((int) $datas['Common']);
        $entity->setRare((int) $datas['Rare']);
        $entity->setEpic((int) $datas['Epic']);
    }
}
