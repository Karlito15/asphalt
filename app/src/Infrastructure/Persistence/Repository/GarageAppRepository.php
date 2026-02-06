<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Infrastructure\Persistence\Entity\GarageApp;
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
//        $datas = [];
//        foreach ($this->findBy([], ['gameUpdate' => 'ASC']) as $garage) {
//            $datas[] = [
//                'Brand' => $garage->getSettingBrand()->getName(),
//                'Model' => $garage->getModel(),
//                'Stars' => $garage->getStars(),
//                'GameUpdate' => $garage->getGameUpdate(),
//                'CarOrder' => $garage->getCarOrder(),
//                'StatOrder' => $garage->getStatOrder(),
//                'Level' => $garage->getLevel(),
//                'Epic' => $garage->getEpic(),
//                'SettingClassValue' => $garage->getSettingClass()->getValue(),
//            ];
//        }
//
//        return $datas;

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

    // SITEMAP

    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemap(): array
    {
        return
            $this->createQueryBuilder('g')
                ->select(['g.id', 'g.slug'])
                ->orderBy('g.gameUpdate', 'ASC')
                ->addOrderBy('g.id', 'ASC')
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
