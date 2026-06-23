<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingBrand;

class Brand
{
    public static function create(array $datas): SettingBrand
    {
        $entity = new SettingBrand();
        $entity->setName($datas['Name']);

        return $entity;
    }

    public static function update(SettingBrand $entity, array $datas): SettingBrand
    {
        $entity->setName($datas['Name']);

        return $entity;
    }
}
