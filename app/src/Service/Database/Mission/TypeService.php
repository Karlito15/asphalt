<?php

declare(strict_types=1);

namespace App\Service\Database\Mission;

use App\Entity\MissionType;
use App\Interface\DatabaseServiceInterface;
use App\Repository\MissionTypeRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TypeService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'missions';

    private static string $file = 'type.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly MissionTypeRepository      $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Mission Type');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Mission Type');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): MissionType
    {
        $entity = new MissionType();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Value', 'Slug'];
    }
}
