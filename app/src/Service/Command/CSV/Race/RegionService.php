<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Race;

use App\Persistence\Entity\RaceRegion;
use App\Persistence\Repository\RaceRegionRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RegionService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'races';

    private static string $file = 'region.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceRegionRepository   $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     * @throws Exception
     */
    public function import(SymfonyStyle $io, string $directory): void
    {
        $io->text('From CSV : Race Region');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Race Region');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return RaceRegion
     */
    public function createEntity(array $datas): RaceRegion
    {
        $entity = new RaceRegion();
        $entity->setName($datas['Name']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.region');
    }
}
