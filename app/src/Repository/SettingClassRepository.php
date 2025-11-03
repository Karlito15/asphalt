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
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.label AS Label, q.value AS Value, q.classOrder AS Order, q.carsNumber AS Number, q.median AS Median, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.classOrder', 'ASC');

        return $qb->getQuery()->getArrayResult();
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
