<?php

namespace App\Repository;

use App\Entity\SettingBrand;
use App\Trait\Repository\SitemapTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingBrand>
 */
class SettingBrandRepository extends ServiceEntityRepository
{
    use SitemapTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingBrand::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.name AS Name, q.cars_number AS Number, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param SettingBrand $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingBrand $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingBrand $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingBrand $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
