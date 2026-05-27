<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceRegion;

class Region
{
    public static function create(array $datas): RaceRegion
    {
        $entity = new RaceRegion();
        $entity->setName($datas["Name"]);

        return $entity;
    }

    public static function update(RaceRegion $entity, array $datas): RaceRegion
    {
        $entity->setName($datas["Name"]);

        return $entity;
    }
}
