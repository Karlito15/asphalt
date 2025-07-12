<?php

namespace App\Repository;

use App\Entity\RaceApp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceApp>
 */
class RaceAppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceApp::class);
    }

    /**
     * @return RaceApp[]
     */
    public function getRaces(): array
    {
        return $this->query()->getQuery()->getArrayResult();
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return RaceApp[]
     */
    public function exportDatas(): array
    {
        $datas = [];
        foreach ($this->findBy([], ['season' => 'ASC', 'raceOrder' => 'ASC']) as $race) {
            $datas[] = [
                'Season' => $race->getSeason()->getName(),
                'RaceOrder' => $race->getRaceOrder(),
                'Mode' => $race->getMode()->getName(),
                'Time' => $race->getTime()->getName(),
                'English' => $race->getTrack()->getNameEnglish(),
            ];
        }

        return $datas;
    }

    /**
     * @param RaceApp $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceApp $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return QueryBuilder
     */
    private function query(): QueryBuilder
    {
        $q  = "r.raceOrder as Order, r.finished AS Finished, r.slug AS Slug";
        $qb = $this->createQueryBuilder('r')->select($q);
        $qb
            // SELECT
            ->addselect('RaceMode.name AS Mode')
            ->addselect('RaceSeason.chapter AS Chapter')
            ->addselect('RaceSeason.name AS Season')
            ->addselect('RaceTime.name AS Time')
            ->addselect('RaceTrack.nameEnglish AS English')
            ->addselect('RaceTrack.nameFrench AS French')
            // JOIN
            ->innerJoin('r.mode', 'RaceMode')
            ->innerJoin('r.season', 'RaceSeason')
            ->innerJoin('r.time', 'RaceTime')
            ->innerJoin('r.track', 'RaceTrack')
            // ORDER BY
            ->addOrderBy('Chapter', 'ASC')
            ->addOrderBy('Season', 'ASC')
            ->addOrderBy('r.raceOrder', 'ASC')
        ;

        return $qb;
    }

    //    /**
    //     * @return RaceApp[] Returns an array of RaceApp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RaceApp
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
