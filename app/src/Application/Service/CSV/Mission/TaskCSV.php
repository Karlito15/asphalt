<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Mission;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\MissionTask;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\MissionTaskRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TaskCSV implements CSVInterface
{
    use MigrationCSV;

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
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
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
     * @return string
     */
    public function getFolder(): string
    {
        return 'missions';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.mission.task');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.mission.commons');
    }
}
