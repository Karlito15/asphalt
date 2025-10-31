<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Garage;

use App\Entity\GarageStatActual;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageStatActualRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatActualService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR .'garages';

    private static string $file = 'garage-stat-actual.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatActualRepository $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Stat Actual');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Stat Actual');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageStatActual
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatActual();
        $entity->setSpeed((float) $datas['Speed']);
        $entity->setAcceleration((float) $datas['Acceleration']);
        $entity->setHandling((float) $datas['Handling']);
        $entity->setNitro((float) $datas['Nitro']);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Speed', 'Acceleration', 'Handling', 'Nitro', 'Average', 'Brand', 'Model'];
    }
}
