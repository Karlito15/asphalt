<?php

namespace App\Repository;

use App\DTO\SearchGarageDTO;
use App\Entity\AppGarage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppGarage>
 */
class AppGarageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppGarage::class);
    }

    /**
     * Retourne la valeur de la dernière mise à jour
     *
     * @return int
     * @uses /App/Garage/CreateController
     */
    public function getLastUpdate(): int
    {
        $q = $this->findOneBy([], ['gameUpdate' => 'DESC']);

        return $q->getGameUpdate();
    }

    /**
     * @param SearchGarageDTO|null $search
     * @return AppGarage[]
     */
    public function search(?SearchGarageDTO $search): array
    {
        $qb = $this->queryGarage()
            // ORDER
            ->addOrderBy('sc.classOrder', 'ASC')
            ->addOrderBy('g.carOrder', 'ASC')
        ;
        // WHERE
//        if ($search->getGameUpdate()) {
//            $qb = $qb->andWhere('g.gameUpdate = :gameUpdate')->setParameter('gameUpdate', $search->getGameUpdate());
//        }
        if ($search->getClassLetter()) {
            $qb = $qb->andWhere('sc.value = :letter')->setParameter('letter', $search->getClassLetter());
        }
        if ($search->isLocked()) {
            $qb = $qb->andWhere('gb.locked = 1');
        } elseif ($search->isLocked() === false) {
            $qb = $qb->andWhere('gb.locked = 0');
        }
        if ($search->isGold()) {
            $qb = $qb->andWhere('gb.gold = 1');
        } elseif ($search->isGold() === false) {
            $qb = $qb->andWhere('gb.gold = 0');
        }

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @return  AppGarage[]
     * @uses    \App\Controller\Web\GarageController
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
     * @param string $class
     * @return array
     * @uses \App\Controller\Web\Page\SettingController
     */
    public function getGarageBlueprint(string $class = 'S'): array
    {
        $qb = $this->queryGarage()
            // JOIN
            ->leftJoin('g.blueprint', 'gbl')
            ->addSelect('gbl.star1')
            ->addSelect('gbl.star2')
            ->addSelect('gbl.star3')
            ->addSelect('gbl.star4')
            ->addSelect('gbl.star5')
            ->addSelect('gbl.star6')
            ->addSelect('gbl.total')
            // JOIN
            ->leftJoin('g.settingBlueprint', 'sbp')
            ->addSelect('sbp.star1 AS sbp1')
            ->addSelect('sbp.star2 AS sbp2')
            ->addSelect('sbp.star3 AS sbp3')
            ->addSelect('sbp.star4 AS sbp4')
            ->addSelect('sbp.star5 AS sbp5')
            ->addSelect('sbp.star6 AS sbp6')
            ->addSelect('sbp.total AS sbptotal')
            // WHERE
            ->andWhere('sc.value = :class')
            ->setParameter('class', $class)
            // ORDER
            ->addOrderBy('g.carOrder', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param string $class
     * @return array
     * @uses \App\Controller\Web\Page\SettingController
     */
    public function getGarageRank(string $class): array
    {
        $qb = $this->queryGarage()
            // JOIN
            ->leftJoin('g.rank', 'rank')
            ->addSelect('rank.star0')
            ->addSelect('rank.star1')
            ->addSelect('rank.star2')
            ->addSelect('rank.star3')
            ->addSelect('rank.star4')
            ->addSelect('rank.star5')
            ->addSelect('rank.star6')
            // WHERE
            ->andWhere('sc.value = :class')
            ->setParameter('class', $class)
            // ORDER
            ->addOrderBy('g.carOrder', 'ASC')
        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * @param string $class
     * @return array
     * @uses \App\Controller\Web\Page\SettingController
     */
    public function getGarageUpgrade(string $class): array
    {
        $qb = $this->queryGarage()
            // JOIN
            ->leftJoin('g.upgrade', 'upgrade')
            ->addSelect('upgrade.speed AS speed_installed')
            ->addSelect('upgrade.acceleration AS acceleration_installed')
            ->addSelect('upgrade.handly AS handly_installed')
            ->addSelect('upgrade.nitro AS nitro_installed')
            ->addSelect('upgrade.common AS common_installed')
            ->addSelect('upgrade.rare AS rare_installed')
            ->addSelect('upgrade.epic AS epic_installed')
            // JOIN
            ->leftJoin('g.settingLevel', 'sl')
            ->addSelect('sl.common AS common_to_install')
            ->addSelect('sl.rare AS rare_to_install')
            // WHERE
            ->andWhere('sc.value = :class')
            ->setParameter('class', $class)
            ->andWhere('gb.locked = 0')
            ->andWhere('gb.gold = 0')
            ->andWhere('gb.toUpgrade = 0')
            // ORDER
            ->addOrderBy('g.carOrder', 'ASC')

        ;

        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Retourne la liste des voitures filtrée par Class
     * (doit renvoyer des entités pas de tableaux)
     *
     * @param string $class
     * @return AppGarage[]
     * @uses \App\EventSubscriber\GarageUpdateSubscriber
     */
    public function getCarsByClass(string $class): array
    {
        $qb = $this->createQueryBuilder('g');
        $qb
            ->leftJoin('g.settingClass', 'SettingClass')
            ->andWhere('SettingClass.value = :class')->setParameter('class', $class)
            ->addOrderBy('g.carOrder', 'ASC');
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param AppGarage $entity
     * @param bool $flush
     * @return void
     */
    public function save(AppGarage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param AppGarage $entity
     * @param bool $flush
     * @return void
     */
    public function remove(AppGarage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return QueryBuilder
     */
    private function queryGarage(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('g')
            ->select('g.id')
            ->addSelect('g.gameUpdate')
            ->addSelect('g.carOrder')
            ->addSelect('g.statOrder')
            ->addSelect('g.stars')
            ->addSelect('g.level')
            ->addSelect('g.epic')
            ->addSelect('g.model')
            ->addSelect('g.updatedAt')
            ->addSelect('g.slug')
            // JOIN Boolean
            ->leftJoin('g.boolean', 'gb')
            ->addSelect('gb.locked AS locked')
            ->addSelect('gb.fullBlueprint AS fullbp')
            ->addSelect('gb.gold AS gold')
            ->addSelect('gb.toUnlock AS tounlocked')
            ->addSelect('gb.toUpgrade AS togold')
            ->addSelect('gb.toGold AS toupgrade')
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
}
