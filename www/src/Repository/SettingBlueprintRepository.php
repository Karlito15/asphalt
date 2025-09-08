<?php

namespace App\Repository;

use App\Entity\SettingBlueprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingBlueprint>
 */
class SettingBlueprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingBlueprint::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q.id, q.star1, q.star2, q.star3, q.star4, q.star5, q.star6, q.total, q.slug');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param SettingBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
