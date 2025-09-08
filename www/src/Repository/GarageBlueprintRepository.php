<?php

namespace App\Repository;

use App\Entity\GarageBlueprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageBlueprint>
 */
class GarageBlueprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageBlueprint::class);
    }

    /**
     * @param GarageBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
