<?php

namespace App\Repository;

use App\Entity\SettingClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingClass>
 */
class SettingClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingClass::class);
    }

    /**
     * @return array
     */
    public function getDatas(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select('q.id, q.label, q.value, q.classOrder, q.carsNumber, q.median, q.slug');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        $r = $qb->getQuery();

        return $r->getArrayResult();
    }

    /**
     * @param SettingClass $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingClass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingClass $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingClass $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
