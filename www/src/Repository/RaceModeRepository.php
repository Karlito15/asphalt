<?php

namespace App\Repository;

use App\Entity\RaceMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceMode>
 */
class RaceModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceMode::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q.id, q.name, q.slug');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param RaceMode $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceMode $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
