<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\InventoryApp;
use App\Domain\Service\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InventoryApp>
 */
class InventoryAppRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryApp::class);
    }

    ### DASHBOARD

    /**
     * @param string $query
     * @return InventoryApp[]
     * @example SELECT * FROM inventory_app WHERE foo LIKE 'bar%';
     */
    public function findByCategory(string $query): array
    {
        return $this->findBy(['category' => $query]);
    }

//    /**
//     * Retourne les informations pour les extraire dans un fichier YAML
//     *
//     * @param string $category
//     * @return array
//     */
//    public function sheet(string $category): array
//    {
//        $qb = $this->createQueryBuilder('q');
//        $qb->select([
//            'q.category AS Category',
//            'q.label AS Label',
//            'q.value AS Value',
//            'q.filter AS Filter',
//            'q.position AS Position',
//            'q.active AS Active',
//        ]);
//        $qb->where('q.deletedAt IS NULL');
//        $qb->andWhere('q.category = :category')->setParameter('category', $category);
//        $qb->andWhere('q.active = 1');
//        $qb->orderBy('q.id', 'ASC');
//
//        return $qb->getQuery()->getArrayResult();
//    }

    ### EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('q');
        $qb->select([
            'q.category AS Category',
            'q.label AS Label',
            'q.value AS Value',
            'q.filter AS Filter',
            'q.position AS Position',
            'q.active AS Active',
        ]);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

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

    //    /**
    //     * @return InventoryApp[] Returns an array of InventoryApp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InventoryApp
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
