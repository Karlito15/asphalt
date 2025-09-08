<?php

namespace App\Repository;

use App\Entity\RaceTrack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceTrack>
 */
class RaceTrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceTrack::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q.id, q.nameEnglish, q.nameFrench, q.slug, r.name');
        $qb->leftJoin('q.region', 'r')->addselect('r.name AS region');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param RaceTrack $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceTrack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceTrack $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceTrack $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
