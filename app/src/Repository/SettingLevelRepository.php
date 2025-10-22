<?php

namespace App\Repository;

use App\Entity\SettingLevel;
use App\Trait\Repository\SitemapTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingLevel>
 */
class SettingLevelRepository extends ServiceEntityRepository
{
    use SitemapTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingLevel::class);
    }

    /** @return array */
    public function exportDatas(): array
    {
        $q  = "q.level AS Level, q.common AS Common, q.rare AS Rare, q.epic AS Epic, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

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
}
