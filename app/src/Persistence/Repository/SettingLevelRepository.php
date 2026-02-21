<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\SettingLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingLevel>
 */
class SettingLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingLevel::class);
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $q  = "q.level AS Level, q.common AS Common, q.rare AS Rare, q.epic AS Epic, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    // EVENTS

    /**
     * @param SettingLevel $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingLevel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingLevel $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingLevel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return SettingLevel[] Returns an array of SettingLevel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SettingLevel
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
