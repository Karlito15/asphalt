<?php

namespace App\Repository;

use App\Able\Repository\SitemapsAble;
use App\Entity\SettingClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingClass>
 */
class SettingClassRepository extends ServiceEntityRepository
{
    use SitemapsAble;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingClass::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.label AS Label, q.value AS Value, q.classOrder AS Order, q.carsNumber AS Number, q.median AS Median, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.classOrder', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param SettingClass $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingClass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingClass $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingClass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return SettingClass[] Returns an array of SettingClass objects
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

    //    public function findOneBySomeField($value): ?SettingClass
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
