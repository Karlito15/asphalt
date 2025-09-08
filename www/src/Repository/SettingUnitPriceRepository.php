<?php

namespace App\Repository;

use App\Entity\SettingUnitPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingUnitPrice>
 */
class SettingUnitPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingUnitPrice::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $q  = "q.id, q.level01, q.level01, q.level02, q.level03, q.level04, q.level05, q.level06, q.level07, q.level08, q.level09, ";
        $q .= "q.level10, q.level11, q.level12, q.level13, q.common, q.rare, q.epic, q.slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param SettingUnitPrice $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingUnitPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingUnitPrice $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingUnitPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
