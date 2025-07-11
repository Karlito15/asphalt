<?php

namespace App\Service\Database;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\InventoryApp;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\InventoryAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InventoryService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static null $folder = null;

    private static string $file = 'inventory.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly InventoryAppRepository     $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : App Inventory');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : App Inventory');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): InventoryApp
    {
        $entity = new InventoryApp();
        $entity->setCategory((string) $datas['Category']);
        $entity->setLabel((string) $datas['Label']);
        $entity->setValue((int) $datas['Value']);
        ($datas['Filter'] != "") ? $entity->setFilter($datas['Filter']) : $entity->setFilter(NULL);
        $entity->setPosition($datas['Position']);
        $entity->setActive($datas['Active']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Category', 'Label', 'Value', 'Filter', 'Position', 'Active'];
    }
}
