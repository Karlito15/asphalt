<?php

namespace App\Repository;

use App\Entity\GarageStatMin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatMin>
 */
class GarageStatMinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatMin::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $datas = [];
        foreach ($this->findAll() as $garage) {
            $datas[] = [
                'Speed' => $garage->getSpeed(),
                'Acceleration' => $garage->getAcceleration(),
                'Handly' => $garage->getHandly(),
                'Nitro' => $garage->getNitro(),
                'Average' => $garage->getAverage(),
                'Brand' => $garage->getGarage()->getSettingBrand()->getName(),
                'Model' => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    /**
     * @param GarageStatMin $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatMin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatMin $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatMin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageStatMin[] Returns an array of GarageStatMin objects
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

    //    public function findOneBySomeField($value): ?GarageStatMin
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
