<?php

namespace App\Repository;

use App\Entity\GarageStatActual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatActual>
 */
class GarageStatActualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatActual::class);
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
     * @param GarageStatActual $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageStatActual $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageStatActual $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageStatActual $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
