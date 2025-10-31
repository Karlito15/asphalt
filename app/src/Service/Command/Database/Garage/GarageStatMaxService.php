<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Garage;

use App\Entity\GarageStatMax;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageStatMaxRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatMaxService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR .'garages';

    private static string $file = 'garage-stat-max.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatMaxRepository    $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Stat Max');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Stat Max');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageStatMax
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatMax();
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
