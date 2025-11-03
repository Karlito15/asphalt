<?php

namespace App\Repository;

use App\Entity\GarageStatMax;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatMax>
 */
class GarageStatMaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatMax::class);
    }

    /**
     * Retourne les informations pour les extraire dans un fichier CSV
     *
     * @return array
     */
    public function exportDatas(): array
    {
        $datas = [];
        foreach ($this->findAll() as $garage) {
            $datas[] = [
                'Speed'        => $garage->getSpeed(),
                'Acceleration' => $garage->getAcceleration(),
                'Handling'     => $garage->getHandling(),
                'Nitro'        => $garage->getNitro(),
                'Average'      => $garage->getAverage(),
                'Brand'        => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'        => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    /**
     * @param GarageStatMax $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatMax $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatMax $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
