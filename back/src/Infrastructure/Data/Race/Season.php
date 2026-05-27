<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceSeason;

class Season
{
    public static function create(array $datas): RaceSeason
    {
        $entity = new RaceSeason();
        self::setter($entity, $datas);

        return $entity;
    }

    public static function update(RaceSeason $entity, array $datas): RaceSeason
    {
        self::setter($entity, $datas);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param RaceSeason $entity
     * @param array $datas
     * @return void
     */
    private static function setter(RaceSeason $entity, array $datas): void
    {
        $entity->setChapter($datas['Chapter']);
        $entity->setName($datas['Name']);
    }
}
