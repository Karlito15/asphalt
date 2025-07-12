<?php

namespace App\Repository;

use App\Entity\RaceTrack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceTrack>
 */
class RaceTrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceTrack::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.nameEnglish AS English, q.nameFrench AS French, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->leftJoin('q.region', 'r')->addselect('r.name AS Region');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param RaceTrack $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceTrack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceTrack $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceTrack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return RaceTrack[] Returns an array of RaceTrack objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RaceTrack
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
