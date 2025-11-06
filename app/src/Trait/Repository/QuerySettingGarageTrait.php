<?php

namespace App\Trait\Repository;

use App\Entity\GarageApp;
use Doctrine\ORM\QueryBuilder;

trait QuerySettingGarageTrait
{
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
    public function getUnblockCarsByClass(string $class, bool $value): array
    {
        $qb = $this->querySettingClass($class);
        $qb->andWhere('status.unblock = :value')->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $class
     * @param bool $value
     * @return array
     */
    public function getGoldCarsByClass(string $class, bool $value): array
    {
        $qb = $this->querySettingClass($class);
        $qb->andWhere('status.gold = :value')->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $class
     * @param string $status
     * @param bool $value
     * @return array
     */
    public function getStatusByClass(string $class, string $status, bool $value): array
    {
        $condition = 'status.'.$status.' = :value';
        $qb = $this->querySettingClass($class);
        $qb->andWhere($condition)->setParameter('value', $value);

        return $qb->getQuery()->getResult();
    }

    // END DASHBOARD

    // PRIVATE

    /**
     * @param string $class
     * @return QueryBuilder
     */
    private function querySettingClass(string $class): QueryBuilder
    {
        return $this->createQueryBuilder('g')
            // Join Garage Status
            ->leftJoin('g.status', 'status')
            ->addSelect('status.unblock AS status_unblock')
            ->addSelect('status.gold AS status_gold')
            ->addSelect('status.toUpgradeLevel AS status_to_upgrade_level')
            ->leftJoin('g.settingClass', 'SettingClass')
            ->andWhere('SettingClass.value = :class')->setParameter('class', $class)
            ->addOrderBy('g.carOrder', 'ASC')
        ;
    }
}
