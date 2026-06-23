<?php

namespace App\Infrastructure\Data\Race;

use App\Domain\Entity\RaceApp;
use App\Domain\Entity\RaceMode;
use App\Domain\Entity\RaceSeason;
use App\Domain\Entity\RaceTime;
use App\Domain\Entity\RaceTrack;
use Doctrine\ORM\EntityManagerInterface;

class App
{
    public static function create(EntityManagerInterface $entityManager,array $datas): RaceApp
    {
        $entity = new RaceApp();
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    public static function update(EntityManagerInterface $entityManager,RaceApp $entity, array $datas): RaceApp
    {
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param RaceApp $entity
     * @param array $datas
     * @param EntityManagerInterface $manager
     * @return void
     */
    private static function setter(RaceApp $entity, array $datas, EntityManagerInterface $manager): void
    {
        $entity->setFinished(true);
        $entity->setRaceOrder((int) $datas['RaceOrder']);
        $entity->setMode($manager->getRepository(RaceMode::class)->findOneBy(['name' => $datas['Mode']]));
        $entity->setSeason($manager->getRepository(RaceSeason::class)->findOneBy(['name' => $datas['Season']]));
        $entity->setTime($manager->getRepository(RaceTime::class)->findOneBy(['name' => $datas['Time']]));
        $entity->setTrack($manager->getRepository(RaceTrack::class)->findOneBy(['nameEnglish' => $datas['English']]));
    }
}
