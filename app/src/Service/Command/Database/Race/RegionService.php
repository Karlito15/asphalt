<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Race;

use App\Entity\RaceRegion;
use App\Interface\DatabaseServiceInterface;
use App\Repository\RaceRegionRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RegionService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR . 'races';

    private static string $file = 'region.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceRegionRepository       $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Race Region');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Race Region');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): RaceRegion
    {
        $entity = new RaceRegion();
        $entity->setName($datas['Name']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Name', 'Slug'];
    }
}
