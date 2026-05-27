<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceTime;

class Time
{
    public static function create(array $datas): RaceTime
    {
        $entity = new RaceTime();
        $entity->setName($datas["Name"]);

        return $entity;
    }

    public static function update(RaceTime $entity, array $datas): RaceTime
    {
        $entity->setName($datas["Name"]);

        return $entity;
    }
}
