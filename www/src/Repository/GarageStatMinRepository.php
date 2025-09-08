<?php

namespace App\Repository;

use App\Entity\GarageStatMin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatMin>
 */
class GarageStatMinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatMin::class);
    }

    /**
     * @param GarageStatMin $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatMin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatMin $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatMin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
