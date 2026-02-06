<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Race;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\RaceSeason;
use App\Infrastructure\Persistence\Repository\RaceSeasonRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SeasonService implements DatabaseServiceInterface
{
    use MigrationService;

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
        $this->makeAnExport($directory, );
    }

    /**
     * @param array $datas
     * @return RaceSeason
     */
    public function createEntity(array $datas): RaceSeason
    {
        $entity = new RaceSeason();
        $entity
            ->setChapter((int) $datas['Chapter'])
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
