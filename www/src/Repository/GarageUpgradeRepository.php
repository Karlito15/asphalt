<?php

namespace App\Repository;

use App\Entity\GarageUpgrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageUpgrade>
 */
class GarageUpgradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageUpgrade::class);
    }

    /**
     * @param GarageUpgrade $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageUpgrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageUpgrade $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageUpgrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
