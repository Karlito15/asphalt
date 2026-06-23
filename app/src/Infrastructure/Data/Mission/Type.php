<?php

namespace App\Infrastructure\Data\Mission;

use App\Domain\Entity\MissionType;

class Type
{
    public static function create(array $datas): MissionType
    {
        $entity = new MissionType();
        $entity->setValue($datas["Value"]);

        return $entity;
    }

    public static function update(MissionType $entity, array $datas): MissionType
    {
        $entity->setValue($datas["Value"]);

        return $entity;
    }
}
