<?php

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageStatusControl;
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
                'gs.fullSpeed AS FullSpeed',
                'gs.fullAcceleration AS FullAcceleration',
                'gs.fullHandling AS FullHandling',
                'gs.fullNitro AS FullNitro',
                'gs.fullUpgrade AS FullUpgrade',
                'gs.fullCommon AS FullCommon',
                'gs.fullEpic AS FullEpic',
                'gs.fullRare AS FullRare',
                'gs.fullImport AS FullImport',
                'gs.fullStar1 AS FullStar1',
                'gs.fullStar2 AS FullStar2',
                'gs.fullStar3 AS FullStar3',
                'gs.fullStar4 AS FullStar4',
                'gs.fullStar5 AS FullStar5',
                'gs.fullStar6 AS FullStar6',
                'gs.fullBlueprint AS FullBlueprint',
                'gs.fullEvo AS FullEvo',
                'gs.toInstallSpeed AS ToInstallSpeed',
                'gs.toInstallAcceleration AS ToInstallAcceleration',
                'gs.toInstallHandling AS ToInstallHandling',
                'gs.toInstallNitro AS ToInstallNitro',
                'gs.toInstallNitro AS ToInstallUpgrade',
                'gs.toInstallCommon AS ToInstallCommon',
                'gs.toInstallEpic AS ToInstallEpic',
                'gs.toInstallRare AS ToInstallRare',
                'gs.toInstallImport AS ToInstallImport',
                'gs.toUnblock AS ToUnblock',
                'gs.toGold AS ToGold',
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
