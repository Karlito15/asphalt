<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\RaceApp;
use App\Domain\Service\Repository\SitemapRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RaceApp>
 */
class RaceAppRepository extends ServiceEntityRepository
{
    use SitemapRepository;

    private static array $select = ['r.id as id', 'r.raceOrder as Order', 'r.finished AS Finished', 'r.slug'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RaceApp::class);
    }

    ### EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return RaceApp[]
     */
    public function export(): array
    {
        $datas = [];
        foreach ($this->findBy([], ['season' => 'ASC', 'raceOrder' => 'ASC']) as $race) {
            $datas[] = [
                'Season' => $race->getSeason()->getName(),
                'RaceOrder' => $race->getRaceOrder(),
                'Mode' => $race->getMode()->getName(),
                'Time' => $race->getTime()->getName(),
                'English' => $race->getTrack()->getNameEnglish(),
            ];
        }

        return $datas;
    }

    ### EVENTS

    /**
     * @param RaceApp $entity
     * @param bool $flush
     * @return void
     */
    public function save(RaceApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param RaceApp $entity
     * @param bool $flush
     * @return void
     */
    public function remove(RaceApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    ### SITEMAP

    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    /*
    public function sitemap(): array
    {
        return $this->createQueryBuilder('r')
            // SELECT
            ->select("r.id as id, r.slug AS slug")
            ->addselect('RaceSeason.chapter AS Chapter')
            ->addselect('RaceSeason.name AS Season')
            // JOIN
            ->innerJoin('r.season', 'RaceSeason')
            // ORDER BY
            ->addOrderBy('Chapter', 'ASC')
            ->addOrderBy('Season', 'ASC')
            ->addOrderBy('r.raceOrder', 'ASC')
            // QUERY
            ->getQuery()
            ->getArrayResult()
        ;
    }
    */

    //    /**
    //     * @return RaceApp[] Returns an array of RaceApp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RaceApp
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
