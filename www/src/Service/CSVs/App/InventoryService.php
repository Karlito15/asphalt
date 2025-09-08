<?php

namespace App\Service\CSVs\App;

use App\Able\CommandAble;
use App\Entity\AppInventory;
use App\Repository\AppInventoryRepository;
use App\Able\ServiceAble;
use App\Interface\ServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class InventoryService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly AppInventoryRepository     $repository,
    )
    {
    }

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function import(SymfonyStyle $io): bool
    {
        // Init
        $io->text('From CSV : App Inventory');

        // Get CSV File
        $csv = $this->getCSVFile();
        // dd($csv);

        // Read CSV
        $records = $this->readCSV($csv);
        // dd($records);

        // Progress Bar Start
        $io->progressStart(count($records));

        // Handling
        foreach ($records as $record) {
            // dd($record);
            $entity = $this->createEntity($record);
            // dd($entity);
            $this->entityManager->persist($entity);

            // Progress Bar +1
            $io->progressAdvance();
        }

        // Flush
        try {
            $this->entityManager->flush();
            $this->entityManager->clear();

            return true;
        } catch (ORMException $e) {
            $this->logger->error(__FILE__ . ' : Erreur lors du flush : ' . $e->getMessage());

            return false;
        } finally {
            // Progress Bar Stop
            $io->progressFinish();
        }
    }

    /**
     * @throws CannotInsertRecord
     * @throws Exception
     */
    public function export(SymfonyStyle $io): void
    {
        // Init
        $io->text('From Database : App Inventory');
        $rows = $this->repository->findAll();
        $file = $this->getCSVFile();
        $csv  = self::createCSV($file);
        // Insert first line
        $csv->insertOne(['Category', 'Label', 'Value', 'Filter', 'Position', 'Active']);
        // Insert each line
        foreach ($rows as $row) {
            $csv->insertOne([
                $row->getCategory(),
                $row->getLabel(),
                $row->getValue(),
                $row->getFilter(),
                $row->getPosition(),
                (int) $row->isActive(),
            ]);
        }
    }

    public function createEntity(array $datas): AppInventory
    {
        $entity = new AppInventory();
        $entity->setCategory((string) $datas['Category']);
        $entity->setLabel((string) $datas['Label']);
        $entity->setValue((int) $datas['Value']);
        ($datas['Filter'] != "") ? $entity->setFilter($datas['Filter']) : $entity->setFilter(NULL);
        $entity->setPosition($datas['Position']);
        $entity->setActive($datas['Active']);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory();
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--app-inventory.csv' : 'app-inventory.csv');
    }
}
