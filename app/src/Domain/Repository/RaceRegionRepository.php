<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\RaceRegion;
use App\Domain\Service\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceRegion>
 */
class RaceRegionRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceRegion::class);
    }

    ### EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('q')
            ->select([
                'q.name AS Name',
                'q.slug AS Slug',
            ])
            ->where('q.deletedAt IS NULL')
            ->orderBy('q.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

    /**
     * @param RaceRegion $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceRegion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceRegion $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceRegion $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return RaceRegion[] Returns an array of RaceRegion objects
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

    //    public function findOneBySomeField($value): ?RaceRegion
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
