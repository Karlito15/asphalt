<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\SettingClass;
use App\Toolbox\Trait\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingClass>
 */
class SettingClassRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingClass::class);
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('q')
            ->select([
                'q.label AS Label',
                'q.value AS Value',
                'q.classOrder AS Order',
                'q.carsNumber AS Number',
                'q.median AS Median',
                'q.slug AS Slug',
            ])
            ->where('q.deletedAt IS NULL')
            ->orderBy('q.classOrder', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    // EVENTS

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

    // LIST

    /**
     * @param string $query
     * @return SettingClass
     */
    public function findByClass(string $query): SettingClass
    {
        return $this->findOneBy(['value' => $query]);
    }

    //    /**
    //     * @return SettingClass[] Returns an array of SettingClass objects
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

    //    public function findOneBySomeField($value): ?SettingClass
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
