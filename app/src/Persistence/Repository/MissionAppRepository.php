<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\MissionApp;
use App\Toolbox\Trait\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MissionApp>
 */
class MissionAppRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MissionApp::class);
    }

    ### INDEX

    /**
     * @return array<string, mixed>
     */
    public function getMissions(): array
    {
        $qb = $this->createQueryBuilder('m')
            ->select([
                'm.id',
                'm.week',
                'm.region',
                'm.track',
                'm.class',
                'm.brand',
                'm.description',
                'm.success',
                'm.target'
            ])
            // SELECT
            ->addselect('MissionTask.value AS task')
            ->addselect('MissionType.value AS type')
            // JOIN
            ->innerJoin('m.task', 'MissionTask')
            ->innerJoin('m.type', 'MissionType')
            // ORDER BY
            ->addOrderBy('m.week', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('q')
            ->select([
                'q.week AS Week',
                'q.region AS Region',
                'q.track AS Track',
                'q.class AS Class',
                'q.brand AS Brand',
                'q.description AS Description',
                'q.success AS Success',
                'q.target AS Target',
            ])
            ->where('q.deletedAt IS NULL')
            ->leftJoin('q.task', 'task')
            ->addselect('task.value AS Task')
            ->leftJoin('q.type', 'type')
            ->addselect('type.value AS Type')
            ->orderBy('q.week', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### EVENTS

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
