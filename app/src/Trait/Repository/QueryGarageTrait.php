<?php

namespace App\Trait\Repository;

use App\DTO\Search\GarageDTO;
use App\Entity\GarageApp;
use Doctrine\ORM\QueryBuilder;

trait QueryGarageTrait
{
    /**
     * @uses GarageAppService
     *
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
     * @uses ReadController, GarageCommand
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

    // START PAGE

    /**
     * Pour les pages Pages/Filter & Pages/Settings
     *
     * @param array|null $where
     * @return GarageApp[]
     */
    public function getGaragePageFilter(array|null $where = null): array
    {
        $qb = $this->queryGarage();
        if (!is_null($where)) {
            foreach ($where as $key => $value) {
                $parameter = str_replace('.', '_', $key);
                $qb->andWhere($key . ' = :' . $parameter)->setParameter($parameter, $value);
            }
        }
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

    // END PAGE

    // START SEARCH

    /**
     * @param GarageDTO|null $search
     * @return GarageApp[]
     */
    public function search(?GarageDTO $search): array
    {
        $qb = $this->queryGarage();

        // WHERE
        if ($search->getGameUpdate()) {
            $qb = $qb->andWhere('g.gameUpdate = :gameUpdate')->setParameter('gameUpdate', $search->gameUpdate->getGameUpdate());
        }

        if ($search->getBrand()) {
            $qb = $qb->andWhere('settingBrand.name = :name')->setParameter('name', $search->brand->getName());
        }

        if ($search->getClassLetter()) {
            $qb = $qb->andWhere('settingClass.value = :letter')->setParameter('letter', $search->classLetter->getValue());
        }

        if (!is_null($search->isUnbLock())) {
            $qb = $qb->andWhere('status.unblock = :unblock')->setParameter('unblock', $search->isUnbLock());
        }

        if (!is_null($search->isGold())) {
            $qb = $qb->andWhere('status.gold = :gold')->setParameter('gold', $search->isGold());
        }

        return $qb->getQuery()->getArrayResult();
    }

    // END SEARCH

    // PRIVATE

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
            // Join Garage Gauntlet
            ->leftJoin('g.gauntlet', 'gauntlet')
            ->addSelect('gauntlet.division AS gauntlet_division')
            // Join Garage Rank
            ->leftJoin('g.rank', 'rank')
            ->addSelect('rank.star0 AS rank_star0')
            ->addSelect('rank.star1 AS rank_star1')
            ->addSelect('rank.star2 AS rank_star2')
            ->addSelect('rank.star3 AS rank_star3')
            ->addSelect('rank.star4 AS rank_star4')
            ->addSelect('rank.star5 AS rank_star5')
            ->addSelect('rank.star6 AS rank_star6')
            // Join Garage Stat Actual
            ->leftJoin('g.statActual', 'statActual')
            ->addSelect('statActual.speed AS actual_speed')
            ->addSelect('statActual.acceleration AS actual_acceleration')
            ->addSelect('statActual.handling AS actual_handling')
            ->addSelect('statActual.nitro AS actual_nitro')
            ->addSelect('statActual.average AS actual_average')
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
            // Join Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS status_unblock')
            ->addSelect('status.toUnblock AS status_to_unblock')
            ->addSelect('status.gold AS status_gold')
            ->addSelect('status.toGold AS status_to_gold')
            ->addSelect('status.fullUpgradeLevel AS status_full_upgrade_level')
            ->addSelect('status.toUpgradeLevel AS status_to_upgrade_level')
            ->addSelect('status.fullBlueprintStar1 AS status_full_blueprint_star1')
            ->addSelect('status.fullBlueprintStar2 AS status_full_blueprint_star2')
            ->addSelect('status.fullBlueprintStar3 AS status_full_blueprint_star3')
            ->addSelect('status.fullBlueprintStar4 AS status_full_blueprint_star4')
            ->addSelect('status.fullBlueprintStar5 AS status_full_blueprint_star5')
            ->addSelect('status.fullBlueprintStar6 AS status_full_blueprint_star6')
            ->addSelect('status.fullUpgradeSpeed AS status_full_upgrade_speed')
            ->addSelect('status.toInstallUpgradeSpeed AS status_to_install_upgrade_speed')
            ->addSelect('status.fullUpgradeAcceleration AS status_full_upgrade_acceleration')
            ->addSelect('status.toInstallUpgradeAcceleration AS status_to_install_upgrade_acceleration')
            ->addSelect('status.fullUpgradeHandling AS status_full_upgrade_handling')
            ->addSelect('status.toInstallUpgradeHandling AS status_to_install_upgrade_handling')
            ->addSelect('status.fullUpgradeNitro AS status_full_upgrade_nitro')
            ->addSelect('status.toInstallUpgradeNitro AS status_to_install_upgrade_nitro')
            ->addSelect('status.fullUpgradeCommon AS status_full_upgrade_common')
            ->addSelect('status.toInstallUpgradeCommon AS status_to_install_upgrade_common')
            ->addSelect('status.fullUpgradeRare AS status_full_upgrade_rare')
            ->addSelect('status.toInstallUpgradeRare AS status_to_install_upgrade_rare')
            ->addSelect('status.fullUpgradeEpic AS status_full_upgrade_epic')
            ->addSelect('status.toInstallUpgradeEpic AS status_to_install_upgrade_epic')
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
}
