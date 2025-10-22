<?php

namespace App\Repository;

use App\Entity\InventoryApp;
use App\Trait\Repository\SitemapTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryApp>
 */
class InventoryAppRepository extends ServiceEntityRepository
{
    use SitemapTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryApp::class);
    }

    /**
     * @param string $query
     * @return InventoryApp[]
     * @example SELECT * FROM app_inventory WHERE nom LIKE 'abc%';
     */
    public function findInventoriesByCategory(string $query): array
    {
//        $qb = $this->createQueryBuilder('i');
//        $qb->select('i.id', 'i.category', 'i.label', 'i.filter', 'i.position', 'i.value', 'i.slug');
//        $qb->where('i.category = :category');
//        $qb->setParameter('category', $query);
//        $qb->andWhere('i.active = :active');
//        $qb->setParameter('active', 1);
//        $qb->addOrderBy('i.position', 'ASC');

//        return $qb->getQuery()->getArrayResult();
        return $this->findBy(['category' => $query]);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.category AS Category, q.label AS Label, q.value AS Value, q.filter AS Filter, q.position AS Position, q.active AS Active, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param InventoryApp $entity
     * @param bool $flush
     * @return void
     */
    public function save(InventoryApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param InventoryApp $entity
     * @param bool $flush
     * @return void
     */
    public function remove(InventoryApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
