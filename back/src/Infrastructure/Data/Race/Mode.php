<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceMode;

class Mode
{
    public static function create(array $datas): RaceMode
    {
        $entity = new RaceMode();
        $entity->setName($datas["Name"]);

        return $entity;
    }

    public static function update(RaceMode $entity, array $datas): RaceMode
    {
        $entity->setName($datas["Name"]);

        return $entity;
    }
}
