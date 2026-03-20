<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\DTO\Search\RaceDTO;
use App\Persistence\Entity\RaceApp;
use App\Persistence\Entity\RaceMode;
use App\Persistence\Entity\RaceRegion;
use App\Persistence\Entity\RaceSeason;
use App\Persistence\Entity\RaceTime;
use App\Toolbox\Trait\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceApp>
 */
class RaceAppRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    private static array $select = ['r.id as id', 'r.raceOrder as Order', 'r.finished AS Finished', 'r.slug'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceApp::class);
    }

    ### INDEX

    /**
     * @return array<string, mixed>
     */
    public function getRaces(): array
    {
        $qb = $this->createQueryBuilder('r')->select(self::$select);
        $qb
            // SELECT
            ->addselect('RaceMode.name AS Mode')
            ->addselect('RaceSeason.chapter AS Chapter')
            ->addselect('RaceSeason.name AS Season')
            ->addselect('RaceTime.name AS Time')
            ->addselect('RaceTrack.nameEnglish AS English')
            ->addselect('RaceTrack.nameFrench AS French')
            ->addselect('RaceRegion.name AS Region')
            // JOIN
            ->innerJoin('r.mode', 'RaceMode')
            ->innerJoin('r.season', 'RaceSeason')
            ->innerJoin('r.time', 'RaceTime')
            ->innerJoin('r.track', 'RaceTrack')
            ->innerJoin('RaceTrack.region', 'RaceRegion')
            // ORDER BY
            ->addOrderBy('Chapter', 'ASC')
            ->addOrderBy('Season', 'ASC')
            ->addOrderBy('r.raceOrder', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### SEARCH

    /**
     * @param RaceDTO|null $search
     * @return array
     */
    public function search(?RaceDTO $search): array
    {
        $qb = $this->queryRace();
        // WHERE
        if ($search->mode instanceof RaceMode) {
            $qb->andWhere('RaceMode.name IN (:mode)')->setParameter('mode', $search->mode->getName());
        }
        if ($search->region instanceof RaceRegion) {
            $regionName = $search->region->getName();
            $regionEntity = $this->getEntityManager()->getRepository(RaceRegion::class)->findOneBy(['name' => $regionName]) ;
        }
        if ($search->season instanceof RaceSeason) {
            $qb->andWhere('RaceSeason.name IN (:name)')->setParameter('name', $search->season->getName());
        }
        if ($search->time instanceof RaceTime) {
            $qb->andWhere('RaceTime.name IN (:time)')->setParameter('time', $search->time->getName());
        }
        if (is_int($search->raceOrder)) {
            $qb->andWhere('r.raceOrder = :raceOrder')->setParameter('raceOrder', $search->raceOrder);
        }
        if ($search->finished === true) {
            $qb->andWhere('r.finished = 1');
        }

        return $qb->getQuery()->getArrayResult();
    }

    ### EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return RaceApp[]
     */
    public function export(): array
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

    ### EVENTS

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

    ### SITEMAP

//    /**
//     * Retourne les informations pour le sitemap
//     *
//     * @return array
//     */
//    public function sitemap(): array
//    {
//        return $this->createQueryBuilder('r')
//            // SELECT
//            ->select("r.id as id, r.slug AS slug")
//            ->addselect('RaceSeason.chapter AS Chapter')
//            ->addselect('RaceSeason.name AS Season')
//            // JOIN
//            ->innerJoin('r.season', 'RaceSeason')
//            // ORDER BY
//            ->addOrderBy('Chapter', 'ASC')
//            ->addOrderBy('Season', 'ASC')
//            ->addOrderBy('r.raceOrder', 'ASC')
//            // QUERY
//            ->getQuery()
//            ->getArrayResult()
//        ;
//    }

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
