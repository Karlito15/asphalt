<?php

declare(strict_types=1);

namespace App\Service\Database\Race;

use App\Entity\RaceTime;
use App\Interface\DatabaseServiceInterface;
use App\Repository\RaceTimeRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TimeService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

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
        $entity->setName((int) $datas['Name']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Name'];
    }
}
