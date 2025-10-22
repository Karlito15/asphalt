<?php

namespace App\Repository;

use App\Entity\SettingTag;
use App\Trait\Repository\SitemapTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SettingTag>
 */
class SettingTagRepository extends ServiceEntityRepository
{
    use SitemapTrait;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingTag::class);
    }

    /** @return array */
    public function exportDatas(): array
    {
        $q  = "q.value AS Value, q.carsNumber AS Number, q.slug AS Slug";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param SettingTag $entity
     * @param bool $flush
     * @return void
     */
    public function save(SettingTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param SettingTag $entity
     * @param bool $flush
     * @return void
     */
    public function remove(SettingTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
