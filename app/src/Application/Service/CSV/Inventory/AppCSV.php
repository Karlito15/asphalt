<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Inventory;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\InventoryApp;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\InventoryAppRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppCSV implements CSVInterface
{
    use MigrationCSV;

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
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
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
        $entity->setFilter($datas['Filter']);
        $entity->setPosition((int) $datas['Position']);
        $entity->setActive((bool) $datas['Active']);

        return $entity;
    }

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return 'inventories';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.inventory.app');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.inventory.app');
    }
}
