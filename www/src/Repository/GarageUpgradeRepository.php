<?php

namespace App\Repository;

use App\Entity\GarageUpgrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageUpgrade>
 */
class GarageUpgradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageUpgrade::class);
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
                'Speed'        => $garage->getSpeed(),
                'Acceleration' => $garage->getAcceleration(),
                'Handling'     => $garage->getHandling(),
                'Nitro'        => $garage->getNitro(),
                'Common'       => $garage->getCommon(),
                'Rare'         => $garage->getRare(),
                'Epic'         => $garage->getEpic(),
                'Brand'        => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'        => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    /**
     * @param GarageUpgrade $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageUpgrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageUpgrade $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageUpgrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageUpgrade[] Returns an array of GarageUpgrade objects
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

    //    public function findOneBySomeField($value): ?GarageUpgrade
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
