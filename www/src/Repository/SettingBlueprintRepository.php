<?php

namespace App\Repository;

use App\Able\Repository\SitemapsAble;
use App\Entity\SettingBlueprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingBlueprint>
 */
class SettingBlueprintRepository extends ServiceEntityRepository
{
    use SitemapsAble;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingBlueprint::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.star1 AS Star1, q.star2 AS Star2, q.star3 AS Star3, q.star4 AS Star4, q.star5 AS Star5, q.star6 AS Star6, q.total AS Total, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        // $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param SettingBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return SettingBlueprint[] Returns an array of SettingBlueprint objects
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

    //    public function findOneBySomeField($value): ?SettingBlueprint
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
