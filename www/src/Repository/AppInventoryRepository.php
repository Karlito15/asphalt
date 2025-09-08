<?php

namespace App\Repository;

use App\Entity\AppInventory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppInventory>
 */
class AppInventoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppInventory::class);
    }

    /**
     *
     * @example SELECT * FROM app_inventory WHERE nom LIKE 'abc%';
     * @param string $query
     * @return array
     */
    public function findInventoriesByCategory(string $query): array
    {
        //
        $qb = $this->createQueryBuilder('i');
        $qb->select('i.id', 'i.label', 'i.filter', 'i.position', 'i.value', 'i.slug');
        $qb->where('i.category = :category');
        $qb->setParameter('category', $query);
        $qb->andWhere('i.active = :active');
        $qb->setParameter('active', 1);
        $qb->addOrderBy('i.position', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param AppInventory $entity
     * @param bool $flush
     * @return void
     */
    public function save(AppInventory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param AppInventory $entity
     * @param bool $flush
     * @return void
     */
    public function remove(AppInventory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
