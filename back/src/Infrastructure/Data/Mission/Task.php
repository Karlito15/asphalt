<?php

namespace App\Infrastructure\Data\Mission;

use App\Domain\Entity\MissionTask;

class Task
{
    public static function create(array $datas): MissionTask
    {
        $entity = new MissionTask();
        $entity->setValue($datas["Value"]);

        return $entity;
    }

    public static function update(MissionTask $entity, array $datas): MissionTask
    {
        $entity->setValue($datas["Value"]);

        return $entity;
    }
}
