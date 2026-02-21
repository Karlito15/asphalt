<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageRank;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageRank>
 */
class GarageRankRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageRank::class);
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('gr')
            ->select([
                'b.name AS Brand',
                'g.model AS Model',
                'gr.star0 AS Star0',
                'gr.star1 AS Star1',
                'gr.star2 AS Star2',
                'gr.star3 AS Star3',
                'gr.star4 AS Star4',
                'gr.star5 AS Star5',
                'gr.star6 AS Star6',
            ])
            ->join('g.settingBrand', 'b')
            ->join('gr.garage', 'g')
            ->orderBy('g.gameUpdate', 'ASC')
            ->addOrderBy('b.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
//
//        $datas = [];
//        foreach ($this->findAll() as $garage) {
//            $datas[] = [
//                'Star0' => $garage->getStar0(),
//                'Star1' => $garage->getStar1(),
//                'Star2' => $garage->getStar2(),
//                'Star3' => $garage->getStar3(),
//                'Star4' => $garage->getStar4(),
//                'Star5' => $garage->getStar5(),
//                'Star6' => $garage->getStar6(),
//                'Brand' => $garage->getGarage()->getSettingBrand()->getName(),
//                'Model' => $garage->getGarage()->getModel(),
//            ];
//        }
//
//        return $datas;
    }

    // EVENTS

    /**
     * @param GarageRank $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageRank $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageRank $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageRank[] Returns an array of GarageRank objects
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

    //    public function findOneBySomeField($value): ?GarageRank
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
