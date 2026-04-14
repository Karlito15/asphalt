<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\GarageStatMax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatMax>
 */
class GarageStatMaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatMax::class);
    }

    ### EXPORTS

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
                'gs.speed AS Speed',
                'gs.acceleration AS Acceleration',
                'gs.handling AS Handling',
                'gs.nitro AS Nitro',
                'gs.average AS Average',
            ])
            ->join('gs.garage', 'g')
            ->join('g.settingBrand', 'b')
            ->orderBy('g.gameUpdate', 'ASC')
            ->addOrderBy('b.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

    /**
     * @param GarageStatMax $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatMax $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageStatMax[] Returns an array of GarageStatMax objects
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

    //    public function findOneBySomeField($value): ?GarageStatMax
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
