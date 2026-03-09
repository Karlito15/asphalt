<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatus>
 */
class GarageStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatus::class);
    }

    // DASHBOARD

    /**
     * @param string $status
     * @param bool $value
     * @return GarageStatus[]
     * @example SELECT * FROM garage_status WHERE foo LIKE 'bar%';
     */
    public function findByStatus(string $status, bool $value): array
    {
        return $this->findBy([$status => $value]);
//        return $this->createQueryBuilder('q')
//            ->where('q.' . $status . ' = :value')
//            ->setParameter('value', $value)
//            ->getQuery()
//            ->getResult()
//        ;
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('gs')
            ->select([
                'b.name AS Brand',
                'g.model AS Model',
                'gs.unblock AS Unblock',
                'gs.gold AS Gold',
                'gs.evo AS Evo',
                'gs.eventClass AS EventClass',
                'gs.toUpgrade AS ToUpgrade',
            ])
            ->join('gs.garage', 'g')
            ->join('g.settingBrand', 'b')
            ->orderBy('g.gameUpdate', 'ASC')
            ->addOrderBy('b.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    // EVENTS

    /**
     * @param GarageStatus $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatus $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageStatus[] Returns an array of GarageStatus objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GarageStatus
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
