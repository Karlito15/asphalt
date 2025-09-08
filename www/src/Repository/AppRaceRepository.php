<?php

namespace App\Repository;

use App\DTO\SearchRaceDTO;
use App\Entity\AppRace;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppRace>
 */
class AppRaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppRace::class);
    }

//    /**
//     * @return SearchRaceDTO[]
//     */
//    public function search(): array
//    {
//        $qb = $this->createQueryBuilder('r')
//            ->select('NEW App\\DTO\\SearchRaceDTO(r.id, r.raceOrder, r.finished)')
//            ->groupBy('r.id')
//            ->getQuery()
//        ;
//
//        return $qb->getArrayResult();
//    }

    /**
     * @param SearchRaceDTO|null $search
     * @return array
     */
    public function search(?SearchRaceDTO $search): array
    {
        $qb = $this->query();
        // WHERE
        if ($search->mode instanceof RaceMode) {
            $qb->andWhere('RaceMode.name IN (:mode)')->setParameter('mode', $search->mode->getName());
        }
        if ($search->season instanceof RaceSeason) {
            $qb->andWhere('RaceSeason.name IN (:name)')->setParameter('name', $search->season->getName());
        }
        if ($search->time instanceof RaceTime) {
            $qb->andWhere('RaceTime.name IN (:time)')->setParameter('time', $search->time->getName());
        }
        if (is_int($search->raceOrder)) {
            $qb->andWhere('r.raceOrder = :race')->setParameter('race', $search->getRaceOrder());
        }
        if ($search->finished === true) {
            $qb->andWhere('r.finished = 0');
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return AppRace[]
     */
    public function getRaces(): array
    {
        return $this->query()->getQuery()->getArrayResult();
    }

    /**
     * @param AppRace $entity
     * @param bool $flush
     * @return void
     */
    public function save(AppRace $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param AppRace $entity
     * @param bool $flush
     * @return void
     */
    public function remove(AppRace $entity, bool $flush = false): void
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
        $qb = $this->createQueryBuilder('r')->select('r.id, r.raceOrder, r.finished, r.slug');
        $qb
            // SELECT
            ->addselect('RaceMode.name as mode')
            ->addselect('RaceSeason.chapter as chapter')
            ->addselect('RaceSeason.name as season')
            ->addselect('RaceTime.name as time')
            ->addselect('RaceTrack.nameEnglish as trackEnglish')
            ->addselect('RaceTrack.nameFrench as trackFrench')
            // JOIN
            ->innerJoin('r.mode', 'RaceMode')
            ->innerJoin('r.season', 'RaceSeason')
            ->innerJoin('r.time', 'RaceTime')
            ->innerJoin('r.track', 'RaceTrack')
            // ORDER BY
            ->addOrderBy('chapter', 'ASC')
            ->addOrderBy('season', 'ASC')
            ->addOrderBy('r.raceOrder', 'ASC')
        ;

        return $qb;
    }
}
