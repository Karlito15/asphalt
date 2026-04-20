<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
        'g.updatedAt',
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
        $qb = $this
            ->createQueryBuilder('g')
            ->select(self::$select)
            ### Join Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS status_unblock')
            ->addSelect('status.gold AS status_gold')
            ->addSelect('status.toUpgrade AS status_to_upgrade')
            ### Join Setting Brand
            ->leftJoin('g.settingBrand', 'settingBrand')
            ->addSelect('settingBrand.name AS brand')
            ### Join Setting Class
            ->leftJoin('g.settingClass', 'settingClass')
            ->addSelect('settingClass.value AS class_value')
            ->addSelect('settingClass.classOrder AS class_order')
            ### GROUP BY
            ->groupBy('g.id')
            ### ORDER BY
            ->orderBy('g.gameUpdate', 'DESC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    ### PAGES START

    /**
     * Pour les pages Pages/Filter & Pages/Settings
     *
     * @param array|null $where
     * @return GarageApp[]
     */
    public function getGaragePageFilter(array|null $where = null): array
    {
        $qb = $this->queryGarage();

        ### WHERE
        if (!is_null($where)) {
            foreach ($where as $key => $value) {
                $parameter = str_replace('.', '_', $key);
                $qb->andWhere($key . ' = :' . $parameter)->setParameter($parameter, $value);
            }
        }

        ### ORDER
        $qb->addOrderBy('g.carOrder', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param array|null $where     column and value
     * @param array|null $order     column and sense ('ASC' or 'DESC')
     * @param array|null $limit     offset and limit
     * @return array
     */
    public function getGaragePageOrder(array|null $where = null, array|null $order = null, array|null $limit = null): array
    {
        $qb = $this->queryGarage();

        ### WHERE
        if ($where) {
            $key = key($where);
            $qb->andWhere($key . ' = :value')->setParameter('value', $where[$key]);
        }

        ### ORDER
        if ($order) {
            $key = key($order);
            $qb->addOrderBy($key, $order[$key]);
        }

        ### LIMIT
        if ($limit) {
            $qb->setFirstResult($limit[0])->setMaxResults($limit[1]);
        }


        return $qb->getQuery()->getArrayResult();
    }

    ### PAGES END

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

    ### EXPORTS START

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function export(): array
    {
        $qb = $this
            ->createQueryBuilder('g')
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
        return $this
            ->findOneBy([
                'settingBrand'  => $this->getEntityManager()->getRepository(SettingBrand::class)->findByBrand($brand),
                'model'         => $model
            ])
        ;
    }

    ### EXPORTS END

    ### EVENTS START

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

    ### EVENTS END

    ### SITEMAP

    /**
     * Retourne les informations pour le sitemap
     *
     * @return array
     */
    public function sitemap(): array
    {
        return $this
            ->createQueryBuilder('g')
            ->select(['g.id', 'g.slug'])
            ->orderBy('g.gameUpdate', 'ASC')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    ### PRIVATE METHODS

    /**
     * Retourne toutes les colonnes du Garage avec les liaisons
     *
     * @return QueryBuilder
     */
    private function queryGarage(): QueryBuilder
    {
        return $this->createQueryBuilder('g')
            ->select(self::$select)
            ### Join Garage Blueprint
            //->leftJoin('g.blueprint', 'blueprint')
            //->addSelect('blueprint.star1 AS garage_star1')
            //->addSelect('blueprint.star2 AS garage_star2')
            //->addSelect('blueprint.star3 AS garage_star3')
            //->addSelect('blueprint.star4 AS garage_star4')
            //->addSelect('blueprint.star5 AS garage_star5')
            //->addSelect('blueprint.star6 AS garage_star6')
            //->addSelect('blueprint.total AS garage_total')
            ### Join Garage Gauntlet
            //->leftJoin('g.gauntlet', 'gauntlet')
            //->addSelect('gauntlet.division AS gauntlet_division')
            ### Join Garage Rank
            //->leftJoin('g.rank', 'rank')
            //->addSelect('rank.star0 AS rank_star0')
            //->addSelect('rank.star1 AS rank_star1')
            //->addSelect('rank.star2 AS rank_star2')
            //->addSelect('rank.star3 AS rank_star3')
            //->addSelect('rank.star4 AS rank_star4')
            //->addSelect('rank.star5 AS rank_star5')
            //->addSelect('rank.star6 AS rank_star6')
            ### Join Garage Stat Actual
            //->leftJoin('g.statActual', 'statActual')
            //->addSelect('statActual.speed AS actual_speed')
            //->addSelect('statActual.acceleration AS actual_acceleration')
            //->addSelect('statActual.handling AS actual_handling')
            //->addSelect('statActual.nitro AS actual_nitro')
            //->addSelect('statActual.average AS actual_average')
            ### Join Garage Stat Max
            //->leftJoin('g.statMax', 'statMax')
            //->addSelect('statMax.speed AS max_speed')
            //->addSelect('statMax.acceleration AS max_acceleration')
            //->addSelect('statMax.handling AS max_handling')
            //->addSelect('statMax.nitro AS max_nitro')
            //->addSelect('statMax.average AS max_average')
            ### Join Garage Stat Min
            //->leftJoin('g.statMin', 'statMin')
            //->addSelect('statMin.speed AS min_speed')
            //->addSelect('statMin.acceleration AS min_acceleration')
            //->addSelect('statMin.handling AS min_handling')
            //->addSelect('statMin.nitro AS min_nitro')
            //->addSelect('statMin.average AS min_average')
            ### Join Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS status_unblock')
            ->addSelect('status.gold AS status_gold')
            ->addSelect('status.toUpgrade AS status_to_upgrade')
            ### Join Garage Upgrade
            //->leftJoin('g.upgrade', 'upgrade')
            //->addSelect('upgrade.speed AS upgrade_speed')
            //->addSelect('upgrade.acceleration AS upgrade_acceleration')
            //->addSelect('upgrade.handling AS upgrade_handling')
            //->addSelect('upgrade.nitro AS upgrade_nitro')
            //->addSelect('upgrade.common AS upgrade_common')
            //->addSelect('upgrade.rare AS upgrade_rare')
            //->addSelect('upgrade.epic AS upgrade_epic')
            ### Join Setting Blueprint
            //->leftJoin('g.settingBlueprint', 'settingBlueprint')
            //->addSelect('settingBlueprint.star1 AS blueprint_star1')
            //->addSelect('settingBlueprint.star2 AS blueprint_star2')
            //->addSelect('settingBlueprint.star3 AS blueprint_star3')
            //->addSelect('settingBlueprint.star4 AS blueprint_star4')
            //->addSelect('settingBlueprint.star5 AS blueprint_star5')
            //->addSelect('settingBlueprint.star6 AS blueprint_star6')
            //->addSelect('settingBlueprint.total AS blueprint_total')
            ### Join Setting Brand
            ->leftJoin('g.settingBrand', 'settingBrand')
            ->addSelect('settingBrand.name AS brand')
            ### Join Setting Class
            ->leftJoin('g.settingClass', 'settingClass')
            ->addSelect('settingClass.value AS class_value')
            ->addSelect('settingClass.classOrder AS class_order')
            //->addSelect('settingClass.carsNumber AS class_number')
            //->addSelect('settingClass.median AS class_median')
            ### Join Setting Level
            //->leftJoin('g.settingLevel', 'SettingLevel')
            //->addSelect('SettingLevel.level AS level_level')
            //->addSelect('SettingLevel.common AS level_common')
            //->addSelect('SettingLevel.rare AS level_rare')
            //->addSelect('SettingLevel.epic AS level_epic')
            ### Join Setting Unit Price
            //->leftJoin('g.settingUnitPrice', 'settingUnitPrice')
            //->addSelect('settingUnitPrice.level01 AS unitPrice_level01')
            //->addSelect('settingUnitPrice.level02 AS unitPrice_level02')
            //->addSelect('settingUnitPrice.level03 AS unitPrice_level03')
            //->addSelect('settingUnitPrice.level04 AS unitPrice_level04')
            //->addSelect('settingUnitPrice.level05 AS unitPrice_level05')
            //->addSelect('settingUnitPrice.level06 AS unitPrice_level06')
            //->addSelect('settingUnitPrice.level07 AS unitPrice_level07')
            //->addSelect('settingUnitPrice.level08 AS unitPrice_level08')
            //->addSelect('settingUnitPrice.level09 AS unitPrice_level09')
            //->addSelect('settingUnitPrice.level10 AS unitPrice_level10')
            //->addSelect('settingUnitPrice.level11 AS unitPrice_level11')
            //->addSelect('settingUnitPrice.level12 AS unitPrice_level12')
            //->addSelect('settingUnitPrice.level13 AS unitPrice_level13')
            //->addSelect('settingUnitPrice.common AS unitPrice_common')
            //->addSelect('settingUnitPrice.rare AS unitPrice_rare')
            //->addSelect('settingUnitPrice.epic AS unitPrice_epic')
            ### GROUP BY
            ->groupBy('g.id');
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
