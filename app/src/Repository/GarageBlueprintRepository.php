<?php

namespace App\Repository;

use App\Entity\GarageBlueprint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageBlueprint>
 */
class GarageBlueprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageBlueprint::class);
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
                'Star1' => $garage->getStar1(),
                'Star2' => $garage->getStar2(),
                'Star3' => $garage->getStar3(),
                'Star4' => $garage->getStar4(),
                'Star5' => $garage->getStar5(),
                'Star6' => $garage->getStar6(),
                'Brand' => $garage->getGarage()->getSettingBrand()->getName(),
                'Model' => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    /**
     * @param GarageBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageBlueprint $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageBlueprint $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
