<?php

namespace App\Repository;

use App\Entity\GarageRank;
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
                'Star0' => $garage->getStar0(),
                'Star1' => $garage->getStar1(),
                'Star2' => $garage->getStar2(),
                'Star3' => $garage->getStar3(),
                'Star4' => $garage->getStar4(),
                'Star5' => $garage->getStar5(),
                'Star6' => $garage->getStar6(),
                'Brand' => $garage->getGarage()->getSettingBrand()->getName(),
                'Model' => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

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
