<?php

namespace App\Repository;

use App\Able\Repository\SitemapsAble;
use App\Entity\SettingUnitPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingUnitPrice>
 */
class SettingUnitPriceRepository extends ServiceEntityRepository
{
    use SitemapsAble;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingUnitPrice::class);
    }

    /**
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.level01 AS Level01, q.level02 AS Level02, q.level03 AS Level03, q.level04 AS Level04, ";
        $q .= "q.level05 AS Level05, q.level06 AS Level06, q.level07 AS Level07, q.level08 AS Level08, ";
        $q .= "q.level09 AS Level09, q.level10 AS Level10, q.level11 AS Level11, q.level12 AS Level12, ";
        $q .= "q.level13 AS Level13, q.common AS Common, q.rare AS Rare, q.epic AS Epic, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
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

    //    /**
    //     * @return SettingUnitPrice[] Returns an array of SettingUnitPrice objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SettingUnitPrice
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
