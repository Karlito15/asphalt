<?php

namespace App\Repository;

use App\Entity\GarageStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GarageStatus>
 */
class GarageStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GarageStatus::class);
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
        foreach ($this->findAll() as $garage) {
            $datas[] = [
                'Unblock'                      => $garage->isUnblock(),
                'ToUnblock'                    => $garage->isToUnblock(),
                'Gold'                         => $garage->isGold(),
                'ToGold'                       => $garage->isToGold(),
                'fullUpgradeLevel'             => $garage->isFullUpgradeLevel(),
                'toUpgradeLevel'               => $garage->isToUpgradeLevel(),
                'fullBlueprintStar1'           => $garage->isFullBlueprintStar1(),
                'fullBlueprintStar2'           => $garage->isFullBlueprintStar2(),
                'fullBlueprintStar3'           => $garage->isFullBlueprintStar3(),
                'fullBlueprintStar4'           => $garage->isFullBlueprintStar4(),
                'fullBlueprintStar5'           => $garage->isFullBlueprintStar5(),
                'fullBlueprintStar6'           => $garage->isFullBlueprintStar6(),
                'fullUpgradeSpeed'             => $garage->isFullUpgradeSpeed(),
                'toInstallUpgradeSpeed'        => $garage->isToInstallUpgradeSpeed(),
                'fullUpgradeAcceleration'      => $garage->isFullUpgradeAcceleration(),
                'toInstallUpgradeAcceleration' => $garage->isToInstallUpgradeAcceleration(),
                'fullUpgradeHandling'          => $garage->isFullUpgradeHandling(),
                'toInstallUpgradeHandling'     => $garage->isToInstallUpgradeHandling(),
                'fullUpgradeNitro'             => $garage->isFullUpgradeNitro(),
                'toInstallUpgradeNitro'        => $garage->isToInstallUpgradeNitro(),
                'fullUpgradeCommon'            => $garage->isFullUpgradeCommon(),
                'toInstallUpgradeCommon'       => $garage->isToInstallUpgradeCommon(),
                'fullUpgradeRare'              => $garage->isFullUpgradeRare(),
                'toInstallUpgradeRare'         => $garage->isToInstallUpgradeRare(),
                'fullUpgradeEpic'              => $garage->isFullUpgradeEpic(),
                'toInstallUpgradeEpic'         => $garage->isToInstallUpgradeEpic(),
                'Brand'                        => $garage->getGarage()->getSettingBrand()->getName(),
                'Model'                        => $garage->getGarage()->getModel(),
            ];
        }

        return $datas;
    }
}
