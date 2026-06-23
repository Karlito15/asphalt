<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingUnitPrice;

class UnitPrice
{
    public static function create(array $datas): SettingUnitPrice
    {
        $entity = new SettingUnitPrice();
        self::setter($entity, $datas);

        return $entity;
    }

    public static function update(SettingUnitPrice $entity, array $datas): SettingUnitPrice
    {
        self::setter($entity, $datas);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param SettingUnitPrice $entity
     * @param array $datas
     * @return void
     */
    private static function setter(SettingUnitPrice $entity, array $datas): void
    {
        $entity->setLevel01((int) $datas['Level01']);
        $entity->setLevel02((int) $datas['Level02']);
        $entity->setLevel03((int) $datas['Level03']);
        $entity->setLevel04((int) $datas['Level04']);
        $entity->setLevel05((int) $datas['Level05']);
        $entity->setLevel06((int) $datas['Level06']);
        $entity->setLevel07((int) $datas['Level07']);
        $entity->setLevel08((int) $datas['Level08']);
        $entity->setLevel09((int) $datas['Level09']);
        $entity->setLevel10((int) $datas['Level10']);
        $entity->setLevel11((int) $datas['Level11']);
        $entity->setLevel12((int) $datas['Level12']);
        $entity->setLevel13((int) $datas['Level13']);
        $entity->setCommon((int) $datas['Common']);
        $entity->setRare((int) $datas['Rare']);
        $entity->setEpic((int) $datas['Epic']);
    }
}
