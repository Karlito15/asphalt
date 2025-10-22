<?php

declare(strict_types=1);

namespace App\Service\Database\Mission;

use App\Entity\MissionTask;
use App\Interface\DatabaseServiceInterface;
use App\Repository\MissionTaskRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TaskService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'missions';

    private static string $file = 'task.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly MissionTaskRepository      $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Mission Task');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Mission Task');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): MissionTask
    {
        $entity = new MissionTask();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Value', 'Slug'];
    }
}
