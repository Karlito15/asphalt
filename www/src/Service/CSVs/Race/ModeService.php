<?php

namespace App\Service\CSVs\Race;

use App\Able\CommandAble;
use App\Entity\RaceMode;
use App\Repository\RaceModeRepository;
use App\Able\ServiceAble;
use App\Interface\ServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ModeService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceModeRepository         $repository,
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
        $io->text('From CSV : Race Mode');

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
     * @throws Exception
     */
    public function export(SymfonyStyle $io): void
    {
        // Init
        $io->text('From Database : Race Mode');

        try {
            $rows = $this->repository->findBy([], ['name' => 'ASC']);
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Name']);
            foreach ($rows as $row) {
                $csv->insertOne([$row->getName()]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): RaceMode
    {
        $entity = new RaceMode();
        $entity->setName($datas['Name']);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'races' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--mode.csv' : 'mode.csv');
    }
}
