<?php

namespace App\Repository;

use App\Entity\GarageGauntlet;
use App\Trait\Repository\SitemapTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageGauntlet>
 */
class GarageGauntletRepository extends ServiceEntityRepository
{
    use SitemapTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageGauntlet::class);
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
                'Speed'         => $garage->getSpeed(),
                'Acceleration'  => $garage->getAcceleration(),
                'Handling'      => $garage->getHandling(),
                'Nitro'         => $garage->getNitro(),
                'CalculateMark' => $garage->getCalculateMark(),
                'TempMark'      => $garage->getTempMark(),
                'FinalMark'     => $garage->getFinalMark(),
                'Brand'         => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'         => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }

    /**
     * @param GarageGauntlet $entity
     * @param bool $flush
     * @return void
     */
    public function save(GarageGauntlet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param GarageGauntlet $entity
     * @param bool $flush
     * @return void
     */
    public function remove(GarageGauntlet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
