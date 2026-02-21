<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Mission;

use App\Persistence\Entity\MissionTask;
use App\Persistence\Repository\MissionTaskRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TaskService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'missions';

    private static string $file = 'task.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly MissionTaskRepository  $repository,
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
        $io->text('From CSV : Mission Task');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Mission Task');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return MissionTask
     */
    public function createEntity(array $datas): MissionTask
    {
        $entity = new MissionTask();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.mission.commons');
    }
}
