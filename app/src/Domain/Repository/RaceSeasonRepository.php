<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\RaceSeason;
use App\Domain\Service\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceSeason>
 */
class RaceSeasonRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceSeason::class);
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
                'q.chapter AS Chapter',
                'q.name AS Name',
                'q.slug AS Slug',
            ])
            ->where('q.deletedAt IS NULL')
            ->orderBy('q.chapter', 'ASC')
            ->addOrderBy('q.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

    /**
     * @param RaceSeason $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceSeason $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return RaceSeason[] Returns an array of RaceSeason objects
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

    //    public function findOneBySomeField($value): ?RaceSeason
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
