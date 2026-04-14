<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\GarageStatusControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatusControl>
 */
class GarageStatusControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatusControl::class);
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
                'gs.toInstallSpeed AS ToInstallSpeed',
                'gs.fullSpeed AS FullSpeed',
                'gs.toInstallAcceleration AS ToInstallAcceleration',
                'gs.fullAcceleration AS FullAcceleration',
                'gs.toInstallHandling AS ToInstallHandling',
                'gs.fullHandling AS FullHandling',
                'gs.toInstallNitro AS ToInstallNitro',
                'gs.fullNitro AS FullNitro',
                'gs.toInstallCommon AS ToInstallCommon',
                'gs.fullCommon AS FullCommon',
                'gs.toInstallRare AS ToInstallRare',
                'gs.fullRare AS FullRare',
                'gs.toInstallEpic AS ToInstallEpic',
                'gs.fullEpic AS FullEpic',
                'gs.fullStar1 AS FullStar1',
                'gs.fullStar2 AS FullStar2',
                'gs.fullStar3 AS FullStar3',
                'gs.fullStar4 AS FullStar4',
                'gs.fullStar5 AS FullStar5',
                'gs.fullStar6 AS FullStar6',
                'gs.fullBlueprint AS FullBlueprint',
                'gs.toInstallUpgrade AS ToInstallUpgrade',
                'gs.fullUpgrade AS FullUpgrade',
                'gs.toInstallImport AS ToInstallImport',
                'gs.fullImport AS FullImport',
                'gs.toGold AS ToGold',
                'gs.fullEvo AS FullEvo',
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
     * @param GarageStatusControl $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatusControl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatusControl $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatusControl $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return GarageStatusControl[] Returns an array of GarageStatusControl objects
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

    //    public function findOneBySomeField($value): ?GarageStatusControl
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
