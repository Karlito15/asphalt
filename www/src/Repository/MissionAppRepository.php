<?php

namespace App\Repository;

use App\Able\Repository\SitemapsAble;
use App\Entity\MissionApp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MissionApp>
 */
class MissionAppRepository extends ServiceEntityRepository
{
    use SitemapsAble;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MissionApp::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $q  = "q.week AS Week, q.region AS Region, q.track AS Track, q.class AS Class, q.brand AS Brand, ";
        $q .= "q.description AS Description, q.success AS Success, q.target AS Target";
        $qb = $this->createQueryBuilder('q');
        $qb->select($q);
        $qb->leftJoin('q.task', 'task')->addselect('task.value AS Task');
        $qb->leftJoin('q.type', 'type')->addselect('type.value AS Type');
        $qb->where('q.deletedAt IS NULL');
        $qb->orderBy('q.id', 'ASC');
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param MissionApp $entity
     * @param bool $flush
     * @return void
     */
    public function save(MissionApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param MissionApp $entity
     * @param bool $flush
     * @return void
     */
    public function remove(MissionApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return MissionApp[] Returns an array of MissionApp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MissionApp
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
