<?php

namespace App\Repository;

use App\Entity\GarageApp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
        $q = $this->findOneBy([], ['gameUpdate' => 'DESC']);

        return $q->getGameUpdate();
    }

    /**
     * @return  GarageApp[]
     */
    public function getGarage(): array
    {
        $qb = $this->queryGarage()
            // ORDER
            ->addOrderBy('g.gameUpdate', 'DESC')
            ->addOrderBy('sc.classOrder', 'DESC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des voitures filtrée par Class
     * Doit impérativement renvoyer des entités pas un tableau
     *
     * @param string $class
     * @return GarageApp[]
     */
    public function getCarsByClass(string $class): array
    {
        $qb = $this->querySettingClass($class);

        return $qb->getQuery()->getResult();
    }

    // DASHBOARD

    /**
     * @param string $class
     * @param bool $value
     * @return array
     */
    public function getCarsUnlockedByClass(string $class, bool $value): array
    {
        $qb = $this->querySettingClass($class);
        $qb->andWhere('g.unlocked = :value')->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $class
     * @param bool $value
     * @return array
     */
    public function getCarsGoldByClass(string $class, bool $value): array
    {
        $qb = $this->querySettingClass($class);
        $qb->andWhere('g.gold = :value')->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    // CSV


    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $datas = [];
        foreach ($this->findBy([], ['gameUpdate' => 'ASC']) as $garage) {
            $datas[] = [
                'Brand' => $garage->getSettingBrand()->getName(),
                'Model' => $garage->getModel(),
                'Stars' => $garage->getStars(),
                'GameUpdate' => $garage->getGameUpdate(),
                'CarOrder' => $garage->getCarOrder(),
                'StatOrder' => $garage->getStatOrder(),
                'Level' => $garage->getLevel(),
                'Epic' => $garage->getEpic(),
                'Locked' => ($garage->isUnlocked()) ? 1 : 0,
                'Gold' => ($garage->isGold()) ? 1 : 0,
                'SettingClassValue' => $garage->getSettingClass()->getValue(),
            ];
        }

        return $datas;
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

    /** @return QueryBuilder */
    private function queryGarage(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g.id')
            ->addSelect('g.stars')
            ->addSelect('g.gameUpdate')
            ->addSelect('g.carOrder')
            ->addSelect('g.statOrder')
            ->addSelect('g.level')
            ->addSelect('g.epic')
            ->addSelect('g.model')
            ->addSelect('g.unlocked')
            ->addSelect('g.gold')
            ->addSelect('g.slug')
            ->addSelect('g.updatedAt')
            // JOIN SettingBrand
            ->leftJoin('g.settingBrand', 'sb')
            ->addSelect('sb.name AS brand')
            // JOIN settingClass
            ->leftJoin('g.settingClass', 'sc')
            ->addSelect('sc.value AS classValue')
            ->addSelect('sc.classOrder AS classOrder')
            ->addSelect('sc.carsNumber AS carsNumber')
            // GROUP BY
            ->groupBy('g.id')
        ;

        return $qb;
    }

    private function querySettingClass(string $class): QueryBuilder
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.settingClass', 'SettingClass')
            ->andWhere('SettingClass.value = :class')->setParameter('class', $class)
            ->addOrderBy('g.carOrder', 'ASC')
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
