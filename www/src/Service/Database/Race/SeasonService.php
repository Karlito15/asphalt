<?php

namespace App\Service\Database\Race;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\RaceSeason;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\RaceSeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SeasonService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'races';

    private static string $file = 'season.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceSeasonRepository $repository,
    )
    {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Race Season');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Race Season');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): RaceSeason
    {
        $entity = new RaceSeason();
        $entity
            ->setChapter((int) $datas['Chapter'])
            ->setName((string) $datas['Name'])
        ;

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Chapter', 'Name', 'Slug'];
    }
}
