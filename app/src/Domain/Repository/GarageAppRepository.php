<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageApp>
 */
class GarageAppRepository extends ServiceEntityRepository
{
    private static array $select = [
        'g.id',
        'g.stars',
        'g.gameUpdate',
        'g.carOrder',
        'g.statOrder',
        'g.level',
        'g.epic',
        'g.evo',
        'g.model',
        'g.slug',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageApp::class);
    }

    ### INDEX

    /**
     * Retourne les voitures du garage
     *
     * @return array<string, mixed>
     */
    public function findList(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select(self::$select)
            // Join Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS status_unblock')
            ->addSelect('status.gold AS status_gold')
            ->addSelect('status.toUpgrade AS status_to_upgrade')
            // Join Setting Brand
            ->leftJoin('g.settingBrand', 'settingBrand')
            ->addSelect('settingBrand.name AS brand')
            // Join Setting Class
            ->leftJoin('g.settingClass', 'settingClass')
            ->addSelect('settingClass.value AS class_value')
            ->addSelect('settingClass.classOrder AS class_order')
            ->addSelect('settingClass.carsNumber AS class_number')
            // GROUP BY
            ->groupBy('g.id')
            // ORDER BY
            ->orderBy('g.gameUpdate', 'DESC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### CREATE

    /**
     * Retourne la valeur de la dernière mise à jour
     *
     * @return int
     */
    public function getLastUpdate(): int
    {
        return $this->findOneBy([], ['gameUpdate' => 'DESC'])->getGameUpdate();
    }

    ### EXPORTS

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
            ])
            ->join('g.settingBrand', 'b')
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
        return $this->findOneBy([
            'settingBrand'  => $this->getEntityManager()->getRepository(SettingBrand::class)->findByBrand($brand),
            'model'         => $model
        ]);
    }

    ### EVENTS

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

    ### SITEMAP

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
