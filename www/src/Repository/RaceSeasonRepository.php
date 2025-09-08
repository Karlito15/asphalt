<?php

namespace App\Repository;

use App\Entity\RaceSeason;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceSeason>
 */
class RaceSeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceSeason::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q.id, q.chapter, q.name, q.slug');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param RaceSeason $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceSeason $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceSeason $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
