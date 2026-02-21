<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageStatActual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatActual>
 */
class GarageStatActualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatActual::class);
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $datas = [];
        foreach ($this->findAll() as $garage) {
            $datas[] = [
                'Speed'        => $garage->getSpeed(),
                'Acceleration' => $garage->getAcceleration(),
                'Handling'     => $garage->getHandling(),
                'Nitro'        => $garage->getNitro(),
                'Average'      => $garage->getAverage(),
                'Brand'        => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'        => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    // EVENTS

    /**
     * @param GarageStatActual $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatActual $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatActual $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatActual $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageStatActual[] Returns an array of GarageStatActual objects
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

    //    public function findOneBySomeField($value): ?GarageStatActual
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
