<?php

namespace App\Repository;

use App\Entity\GarageRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageRank>
 */
class GarageRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageRank::class);
    }

    /**
     * @param GarageRank $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageRank $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
