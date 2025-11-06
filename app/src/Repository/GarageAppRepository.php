<?php

namespace App\Repository;

use App\Entity\GarageApp;
use App\Trait\Repository\QueryGarageTrait;
use App\Trait\Repository\QuerySettingGarageTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageApp>
 */
class GarageAppRepository extends ServiceEntityRepository
{
    use QueryGarageTrait;
    use QuerySettingGarageTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageApp::class);
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

    /**
     * Retourne la valeur de la dernière mise à jour
     * CreateController
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
                'SettingClassValue' => $garage->getSettingClass()->getValue(),
            ];
        }

        return $datas;
    }

    // SITEMAP

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
}
