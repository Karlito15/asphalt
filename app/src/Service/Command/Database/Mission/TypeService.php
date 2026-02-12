<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Mission;

use App\Persistence\Entity\MissionType;
use App\Persistence\Repository\MissionTypeRepository;
use App\Interface\DatabaseServiceInterface;
use App\Service\Command\MigrationService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TypeService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'missions';

    private static string $file = 'type.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly MissionTypeRepository  $repository,
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
        $io->text('From CSV : Mission Type');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Mission Type');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return MissionType
     */
    public function createEntity(array $datas): MissionType
    {
        $entity = new MissionType();
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
