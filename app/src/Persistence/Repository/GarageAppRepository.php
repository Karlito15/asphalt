<?php

declare(strict_types=1);

namespace App\Persistence\Repository;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageApp>
 */
class GarageAppRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageApp::class);
    }

    // CREATE

    /**
     * Retourne la valeur de la dernière mise à jour
     *
     * @return int
     */
    public function getLastUpdate(): int
    {
        return $this->findOneBy([], ['gameUpdate' => 'DESC'])->getGameUpdate();
    }

    // EXPORTS

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select([
                'b.name AS Brand',
                'g.model AS Model',
                'g.stars AS Stars',
                'g.gameUpdate AS GameUpdate',
                'g.carOrder AS CarOrder',
                'g.statOrder AS StatOrder',
                'g.level AS Level',
                'g.epic AS Epic',
                'g.evo AS Evo',
                'c.value AS SettingClassValue',
            ])
            ->join('g.settingBrand', 'b')
            ->join('g.settingClass', 'c')
            ->orderBy('g.gameUpdate', 'ASC')
            ->addOrderBy('b.name', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param string $brand
     * @param string $model
     * @return GarageApp
     * @throws \Exception
     */
    public function findByBrandAndModel(string $brand, string $model): GarageApp
    {
        $brand = $this->getEntityManager()->getRepository(SettingBrand::class)->findByBrand($brand);

        return $this->findoneBy(['settingBrand' => $brand, 'model' => $model]);
    }

    // EVENTS

    /**
     * @param GarageApp $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageApp $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageApp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // LIST

    /**
     * @param string $class
     * @param bool $unblock
     * @param bool $gold
     * @return array
     */
    public function getStatusByClass(string $class, bool $unblock, bool $gold): array
    {
        $q = $this->createQueryBuilder('g');
        $q
            ->select(['g.id', 'g.model', 'g.gameUpdate', 'g.slug'])
            ->orderBy('g.gameUpdate', 'DESC')
            ->groupBy('g.id')
            ### JOIN Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS Unblock')
            ->addSelect('status.gold AS Gold')
            ->addSelect('status.evo AS Evo')
            ->addSelect('status.eventClass AS EventClass')
            ->addSelect('status.toUpgrade AS ToUpgrade')
            ### JOIN SettingBrand
            ->leftJoin('g.settingBrand', 'b')
            ->addSelect('b.name AS Brand')
            ### JOIN settingClass
            ->leftJoin('g.settingClass', 'c')
            ->addSelect('c.value AS Class')
            ### WHERE
            // Class
            ->andWhere('c.value = :value')
            ->setParameter('value', $class)
            // Status
            ->andWhere(
                $q->expr()->andX(
                    $q->expr()->eq('status.unblock', ':unblock'),
                    $q->expr()->eq('status.gold', ':gold')
                )
            )
            ->setParameter('unblock', $unblock)
            ->setParameter('gold', $gold)
        ;

        return $q->getQuery()->getScalarResult();
    }

    // SITEMAP

    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemap(): array
    {
        return $this->createQueryBuilder('g')
            ->select(['g.id', 'g.slug'])
            ->orderBy('g.gameUpdate', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    //    /**
    //     * @return GarageApp[] Returns an array of GarageApp objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GarageApp
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
