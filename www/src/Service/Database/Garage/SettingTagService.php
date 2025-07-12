<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\GarageServiceAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\GarageApp;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\GarageAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingTagService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;
    use GarageServiceAble;

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
