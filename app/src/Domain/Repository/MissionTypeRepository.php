<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\MissionType;
use App\Domain\Service\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MissionType>
 */
class MissionTypeRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MissionType::class);
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
                'q.value AS Value',
                'q.slug AS Slug',
            ])
            ->where('q.deletedAt IS NULL')
            ->orderBy('q.value', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

    /**
     * @param MissionType $entity
     * @param bool $flush
     * @return void
     */
    public function save(MissionType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param MissionType $entity
     * @param bool $flush
     * @return void
     */
    public function remove(MissionType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return MissionType[] Returns an array of MissionType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MissionType
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
