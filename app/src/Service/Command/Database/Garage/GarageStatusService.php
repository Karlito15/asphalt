<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Garage;

use App\Entity\GarageStatus;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageStatusRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatusService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR .'garages';

    private static string $file = 'garage-status.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatusRepository     $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Status');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Status');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageStatus
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatus();
        $entity->setGarage($garage);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Unblock', 'ToUnblock', 'Gold', 'ToGold',
            'FullUpgradeLevel', 'ToUpgradeLevel', 'FullBlueprintStar1', 'FullBlueprintStar2',
            'FullBlueprintStar3', 'FullBlueprintStar4', 'FullBlueprintStar5', 'FullBlueprintStar6',
            'FullUpgradeSpeed', 'ToInstallUpgradeSpeed', 'FullUpgradeAcceleration', 'ToInstallUpgradeAcceleration',
            'FullUpgradeHandling', 'ToInstallUpgradeHandling', 'FullUpgradeNitro', 'ToInstallUpgradeNitro',
            'FullUpgradeCommon', 'ToInstallUpgradeCommon', 'FullUpgradeRare', 'ToInstallUpgradeRare',
            'FullUpgradeEpic', 'ToInstallUpgradeEpic',
            'Brand', 'Model'];
    }
}
