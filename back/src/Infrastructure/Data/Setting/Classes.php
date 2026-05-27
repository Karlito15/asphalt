<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingClass;

class Classes
{
    public static function create(array $datas): SettingClass
    {
        $entity = new SettingClass();
        self::setter($entity, $datas);

        return $entity;
    }

    public static function update(SettingClass $entity, array $datas): SettingClass
    {
        self::setter($entity, $datas);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param SettingClass $entity
     * @param array $datas
     * @return void
     */
    private static function setter(SettingClass $entity, array $datas): void
    {
        $entity->setLabel($datas['Label']);
        $entity->setValue($datas['Value']);
        $entity->setClassOrder((int) $datas['Order']);
        $entity->setMedian((int) $datas['Median']);
    }
}
