<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Entity\GarageApp;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageAppRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingTagService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'setting-tag.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageAppRepository        $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Setting Tag');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Setting Tag');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageApp
    {
    }

    public function getHeader(): array
    {
        return ['Brand', 'Model', 'SettingTag'];
    }
}
