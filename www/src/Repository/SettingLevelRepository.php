<?php

namespace App\Repository;

use App\Entity\SettingLevel;
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

    /**
     * @return array
     */
	public function getDatas(): array
	{
		$qb = $this->createQueryBuilder('q');
		$qb->select('q.id, q.level, q.common, q.rare, q.epic, q.slug');
		$qb->where('q.deletedAt IS NULL');
		$qb->orderBy('q.id', 'ASC');
		$r = $qb->getQuery();

		return $r->getArrayResult();
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
