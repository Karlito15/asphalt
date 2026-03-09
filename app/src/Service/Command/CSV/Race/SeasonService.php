<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Race;

use App\Persistence\Entity\RaceSeason;
use App\Persistence\Repository\RaceSeasonRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SeasonService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'races';

    private static string $file = 'season.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceSeasonRepository   $repository,
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
        $io->text('From CSV : Race Season');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Race Season');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return RaceSeason
     */
    public function createEntity(array $datas): RaceSeason
    {
        $entity = new RaceSeason();
        $entity
            ->setChapter($this->convertStringToInteger($datas['Chapter']))
            ->setName((string) $datas['Name'])
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.season');
    }
}
