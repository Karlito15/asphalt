<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Race;

use App\Persistence\Entity\RaceTime;
use App\Persistence\Repository\RaceTimeRepository;
use App\Interface\DatabaseServiceInterface;
use App\Service\Command\MigrationService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TimeService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'races';

    private static string $file = 'time.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceTimeRepository     $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     * @throws Exception
     */
    public function import(SymfonyStyle $io, string $directory): void
    {
        $io->text('From CSV : Race Time');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Race Track');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return RaceTime
     */
    public function createEntity(array $datas): RaceTime
    {
        $entity = new RaceTime();
        $entity->setName((int) $datas['Name']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.time');
    }
}
