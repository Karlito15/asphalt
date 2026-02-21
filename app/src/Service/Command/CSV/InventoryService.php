<?php

declare(strict_types=1);

namespace App\Service\Command\CSV;

use App\Persistence\Entity\InventoryApp;
use App\Persistence\Repository\InventoryAppRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InventoryService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = '';

    private static string $file = 'inventory.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly InventoryAppRepository $repository,
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
        $io->text('From CSV : Inventory App');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Inventory App');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return InventoryApp
     */
    public function createEntity(array $datas): InventoryApp
    {
        $entity = new InventoryApp();
        $entity->setCategory((string) $datas['Category']);
        $entity->setLabel((string) $datas['Label']);
        $entity->setValue((int) $datas['Value']);
        ($datas['Filter'] != '') ? $entity->setFilter($datas['Filter']) : $entity->setFilter('---');
        $entity->setPosition((int) $datas['Position']);
        $entity->setActive((bool) $datas['Active']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.inventory');
    }
}
