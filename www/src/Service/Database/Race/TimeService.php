<?php

namespace App\Service\Database\Race;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\RaceTime;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\RaceTimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TimeService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'races';

    private static string $file = 'time.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceTimeRepository         $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Race Time');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Race Time');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): RaceTime
    {
        $entity = new RaceTime();
        $entity->setName($datas['Name']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Name'];
    }
}
