<?php

namespace App\Infrastructure\Data\Setting;

use App\Domain\Entity\SettingTag;

class Tag
{
    public static function create(array $datas): SettingTag
    {
        $entity = new SettingTag();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    public static function update(SettingTag $entity, array $datas): SettingTag
    {
        $entity->setValue($datas['Value']);

        return $entity;
    }
}
