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
     * @return array
     */
    public function getGarageFullOption(): array
    {
        $qb = $this->queryGarage()
            // Order
            ->addOrderBy('g.gameUpdate', 'DESC')
            ->addOrderBy('settingClass.classOrder', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @param string $slug
     * @return array
     */
    public function getGarageOne(int $id, string $slug): array
    {
        $qb = $this->queryGarage()
            // Where
            ->andWhere('g.id = :id')->setParameter('id', $id)
            ->andWhere('g.slug = :slug')->setParameter('slug', $slug)
            // Order
            ->addOrderBy('g.gameUpdate', 'DESC')
            ->addOrderBy('settingClass.classOrder', 'DESC')
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Pour les pages Pages/Orders
     *
     * @param array|null $where     column and value
     * @param array|null $order     column and sense ('ASC' or 'DESC')
     * @param array|null $limit     offset and limit
     * @return GarageApp[]
     */
    public function getGarageCondition(array|null $where = null, array|null $order = null, array|null $limit = null): array
    {
        $qb = $this->queryGarage();

        // WHERE
        if ($where) {
            $key = key($where);
            $qb->andWhere($key . ' = :value')->setParameter('value', $where[$key]);
        }

        // ORDER
        if ($order) {
            $key = key($order);
            $qb->addOrderBy($key, $order[$key]);
        }

        // LIMIT
        if ($limit) {
            $qb->setFirstResult($limit[0])->setMaxResults($limit[1]);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Pour les pages Pages/Settings
     *
     * @param string $letter
     * @return GarageApp[]
     */
    public function getGaragePageSetting(string $letter): array
    {
        $qb = $this->queryGarage()
            // WHERE
            ->andWhere('settingClass.value = :class')->setParameter('class', $letter)
            ->andWhere('g.unlocked = 1')
            ->andWhere('g.gold = 0')
            // ORDER
            ->addOrderBy('g.carOrder', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
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

    // START DASHBOARD

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

    /**
     * @param string $class
     * @param bool $value
     * @return array
     */
    public function getUnlockedCarsByClass(string $class, bool $value): array
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
    public function getGoldedCarsByClass(string $class, bool $value): array
    {
        $qb = $this->querySettingClass($class);
        $qb->andWhere('g.gold = :value')->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    // END DASHBOARD



    // EXPORTS

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
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemapDatas(): array
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g.id')
            ->addSelect('g.slug')
            ->orderBy('g.gameUpdate', 'ASC')
            ->orderBy('g.id', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne toutes les colonnes du Garage avec les liaisons
     *
     * @return QueryBuilder
     */
    private function queryGarage(): QueryBuilder
    {
        return $this->createQueryBuilder('g')
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
            // Join Garage Blueprint
            ->leftJoin('g.blueprint', 'blueprint')
            ->addSelect('blueprint.star1 AS garage_star1')
            ->addSelect('blueprint.star2 AS garage_star2')
            ->addSelect('blueprint.star3 AS garage_star3')
            ->addSelect('blueprint.star4 AS garage_star4')
            ->addSelect('blueprint.star5 AS garage_star5')
            ->addSelect('blueprint.star6 AS garage_star6')
            ->addSelect('blueprint.total AS garage_total')
            // Join Garage Rank
            ->leftJoin('g.rank', 'rank')
            ->addSelect('rank.star0 AS rank_star0')
            ->addSelect('rank.star1 AS rank_star1')
            ->addSelect('rank.star2 AS rank_star2')
            ->addSelect('rank.star3 AS rank_star3')
            ->addSelect('rank.star4 AS rank_star4')
            ->addSelect('rank.star5 AS rank_star5')
            ->addSelect('rank.star6 AS rank_star6')
            // Join Garage Stat Max
            ->leftJoin('g.statMax', 'statMax')
            ->addSelect('statMax.speed AS max_speed')
            ->addSelect('statMax.acceleration AS max_acceleration')
            ->addSelect('statMax.handling AS max_handling')
            ->addSelect('statMax.nitro AS max_nitro')
            ->addSelect('statMax.average AS max_average')
            // Join Garage Stat Min
            ->leftJoin('g.statMin', 'statMin')
            ->addSelect('statMin.speed AS min_speed')
            ->addSelect('statMin.acceleration AS min_acceleration')
            ->addSelect('statMin.handling AS min_handling')
            ->addSelect('statMin.nitro AS min_nitro')
            ->addSelect('statMin.average AS min_average')
            // Join Garage Upgrade
            ->leftJoin('g.upgrade', 'upgrade')
            ->addSelect('upgrade.speed AS upgrade_speed')
            ->addSelect('upgrade.acceleration AS upgrade_acceleration')
            ->addSelect('upgrade.handling AS upgrade_handling')
            ->addSelect('upgrade.nitro AS upgrade_nitro')
            ->addSelect('upgrade.common AS upgrade_common')
            ->addSelect('upgrade.rare AS upgrade_rare')
            ->addSelect('upgrade.epic AS upgrade_epic')
            // Join Setting Blueprint
            ->leftJoin('g.settingBlueprint', 'settingBlueprint')
            ->addSelect('settingBlueprint.star1 AS blueprint_star1')
            ->addSelect('settingBlueprint.star2 AS blueprint_star2')
            ->addSelect('settingBlueprint.star3 AS blueprint_star3')
            ->addSelect('settingBlueprint.star4 AS blueprint_star4')
            ->addSelect('settingBlueprint.star5 AS blueprint_star5')
            ->addSelect('settingBlueprint.star6 AS blueprint_star6')
            ->addSelect('settingBlueprint.total AS blueprint_total')
            // Join Setting Brand
            ->leftJoin('g.settingBrand', 'settingBrand')
            ->addSelect('settingBrand.name AS brand')
            // Join Setting Class
            ->leftJoin('g.settingClass', 'settingClass')
            ->addSelect('settingClass.value AS class_value')
            ->addSelect('settingClass.classOrder AS class_order')
            ->addSelect('settingClass.carsNumber AS class_number')
            ->addSelect('settingClass.median AS class_median')
            // Join Setting Level
            ->leftJoin('g.settingLevel', 'SettingLevel')
            ->addSelect('SettingLevel.level AS level_level')
            ->addSelect('SettingLevel.common AS level_common')
            ->addSelect('SettingLevel.rare AS level_rare')
            ->addSelect('SettingLevel.epic AS level_epic')
            // Join Setting Unit Price
            ->leftJoin('g.settingUnitPrice', 'settingUnitPrice')
            ->addSelect('settingUnitPrice.level01 AS unitPrice_level01')
            ->addSelect('settingUnitPrice.level02 AS unitPrice_level02')
            ->addSelect('settingUnitPrice.level03 AS unitPrice_level03')
            ->addSelect('settingUnitPrice.level04 AS unitPrice_level04')
            ->addSelect('settingUnitPrice.level05 AS unitPrice_level05')
            ->addSelect('settingUnitPrice.level06 AS unitPrice_level06')
            ->addSelect('settingUnitPrice.level07 AS unitPrice_level07')
            ->addSelect('settingUnitPrice.level08 AS unitPrice_level08')
            ->addSelect('settingUnitPrice.level09 AS unitPrice_level09')
            ->addSelect('settingUnitPrice.level10 AS unitPrice_level10')
            ->addSelect('settingUnitPrice.level11 AS unitPrice_level11')
            ->addSelect('settingUnitPrice.level12 AS unitPrice_level12')
            ->addSelect('settingUnitPrice.level13 AS unitPrice_level13')
            ->addSelect('settingUnitPrice.common AS unitPrice_common')
            ->addSelect('settingUnitPrice.rare AS unitPrice_rare')
            ->addSelect('settingUnitPrice.epic AS unitPrice_epic')
            // GROUP BY
            ->groupBy('g.id');
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
