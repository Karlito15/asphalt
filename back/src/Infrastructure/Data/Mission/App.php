<?php

namespace App\Infrastructure\Data\Mission;

use App\Domain\Entity\MissionApp;
use App\Domain\Entity\MissionTask;
use App\Domain\Entity\MissionType;
use Doctrine\ORM\EntityManagerInterface;

class App
{
    public static function create(EntityManagerInterface $entityManager, array $datas): MissionApp
    {
        $entity = new MissionApp();
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    public static function update(EntityManagerInterface $entityManager, MissionApp $entity, array $datas): MissionApp
    {
        self::setter($entity, $datas, $entityManager);

        return $entity;
    }

    /** PRIVATE METHOD */

    /**
     * @param MissionApp $entity
     * @param array $datas
     * @param EntityManagerInterface $manager
     * @return void
     */
    private static function setter(MissionApp $entity, array $datas, EntityManagerInterface $manager): void
    {
        $entity->setWeek((int) $datas['Week']);
        $entity->setRegion($datas['Region']);
        $entity->setTrack($datas['Track']);
        $entity->setClass($datas['Class']);
        $entity->setBrand($datas['Brand']);
        $entity->setDescription($datas['Description']);
        $entity->setSuccess((int) $datas['Success']);
        $entity->setTarget((int) $datas['Target']);
        $entity->setTask($manager->getRepository(MissionTask::class)->findOneBy(['value' => $datas['Task']]));
        $entity->setType($manager->getRepository(MissionType::class)->findOneBy(['value' => $datas['Type']]));
    }
}
