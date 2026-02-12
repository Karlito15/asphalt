<?php

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageGauntlet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageGauntlet>
 */
class GarageGauntletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageGauntlet::class);
    }

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
                'Speed'         => $garage->getSpeed(),
                'Acceleration'  => $garage->getAcceleration(),
                'Handling'      => $garage->getHandling(),
                'Nitro'         => $garage->getNitro(),
                'Mark'          => $garage->getMark(),
                'Division'      => $garage->getDivision(),
                'Brand'         => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'         => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;

//        $qb = $this->createQueryBuilder('g')
//            ->select([
//                'g.speed AS Speed',
//                'g.acceleration AS Acceleration',
//                'g.handling AS Handling',
//                'g.nitro AS Mark',
//                'g.division AS Division',
//                'b.name AS Brand',
//                'garage.model AS Model',
//            ])
//            ->join('g.settingBrand', 'b')
//            ->join('g.garage', 'garage')
//            ->orderBy('g.gameUpdate', 'ASC')
//        ;
//
//        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param GarageGauntlet $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageGauntlet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageGauntlet $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageGauntlet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageGauntlet[] Returns an array of GarageGauntlet objects
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

    //    public function findOneBySomeField($value): ?GarageGauntlet
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
