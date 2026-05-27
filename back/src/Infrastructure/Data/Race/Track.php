<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceRegion;
use App\Domain\Entity\RaceTrack;
use Doctrine\ORM\EntityManagerInterface;

class Track
{
    public static function create(EntityManagerInterface $entityManager, array $datas): RaceTrack
    {
        $entity = new RaceTrack();
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    public static function update(EntityManagerInterface $entityManager, RaceTrack $entity, array $datas): RaceTrack
    {
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param RaceTrack $entity
     * @param array $datas
     * @param EntityManagerInterface $manager
     * @return void
     */
    private static function setter(RaceTrack $entity, array $datas, EntityManagerInterface $manager): void
    {
        ### Condition
        $french = (is_null($datas['French']) || $datas['French'] === '') ? null: $datas['French'];

        $entity->setNameEnglish($datas["English"]);
        $entity->setNameFrench($french);
        $entity->setRegion($manager->getRepository(RaceRegion::class)->findOneBy(['name' => $datas['Region']]));
    }
}
