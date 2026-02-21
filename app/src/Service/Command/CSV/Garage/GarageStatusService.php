<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageStatus;
use App\Persistence\Repository\GarageStatusRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatusService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'garage-status.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageStatusRepository $repository,
    )
    {}

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     * @throws Exception
     */
    public function import(SymfonyStyle $io, string $directory): void
    {
        $io->text('From CSV : Garage Status');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Status');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageStatus
     */
    public function createEntity(array $datas): GarageStatus
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatus();
        $entity
//            ->setEvo((bool) $datas['Evo'])
            ->setUnblock((bool) $datas['Unblock'])
            ->setToUnblock((bool) $datas['ToUnblock'])
            ->setGold((bool) $datas['Gold'])
            ->setToGold((bool) $datas['ToGold'])
            ->setFullUpgradeLevel((bool) $datas['FullUpgradeLevel'])
            ->setToUpgradeLevel((bool) $datas['ToUpgradeLevel'])
            ->setFullBlueprintStar1((bool) $datas['FullBlueprintStar1'])
            ->setFullBlueprintStar2((bool) $datas['FullBlueprintStar2'])
            ->setFullBlueprintStar3((bool) $datas['FullBlueprintStar3'])
            ->setFullBlueprintStar4((bool) $datas['FullBlueprintStar4'])
            ->setFullBlueprintStar5((bool) $datas['FullBlueprintStar5'])
            ->setFullBlueprintStar6((bool) $datas['FullBlueprintStar6'])
            ->setFullUpgradeSpeed((bool) $datas['FullUpgradeSpeed'])
            ->setToInstallUpgradeSpeed((bool) $datas['ToInstallUpgradeSpeed'])
            ->setFullUpgradeAcceleration((bool) $datas['FullUpgradeAcceleration'])
            ->setToInstallUpgradeAcceleration((bool) $datas['ToInstallUpgradeAcceleration'])
            ->setFullUpgradeHandling((bool) $datas['FullUpgradeHandling'])
            ->setToInstallUpgradeHandling((bool) $datas['ToInstallUpgradeHandling'])
            ->setFullUpgradeNitro((bool) $datas['FullUpgradeNitro'])
            ->setToInstallUpgradeNitro((bool) $datas['ToInstallUpgradeNitro'])
            ->setFullUpgradeCommon((bool) $datas['FullUpgradeCommon'])
            ->setToInstallUpgradeCommon((bool) $datas['ToInstallUpgradeCommon'])
            ->setFullUpgradeRare((bool) $datas['FullUpgradeRare'])
            ->setToInstallUpgradeRare((bool) $datas['ToInstallUpgradeRare'])
            ->setFullUpgradeEpic((bool) $datas['FullUpgradeEpic'])
            ->setToInstallUpgradeEpic((bool) $datas['ToInstallUpgradeEpic'])
        ;
        $entity->setGarage($garage);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.status');
    }
}
