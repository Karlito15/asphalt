<?php

namespace App\Service\CSVs\Setting;

use App\Able\CommandAble;
use App\Entity\SettingBlueprint;
use App\Repository\SettingBlueprintRepository;
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

class BlueprintService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingBlueprintRepository $repository,
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
        $io->text('From CSV : Setting Blueprint');

        // Get CSV File
        $csv = $this->getCSVFile();
        // dd($csv);

        // Read CSV
        $records = $this->readCSV($csv);
        // dd($records);

        // Progress Bar Start
        $io->progressStart($records->count());

        // Handling
        foreach ($records as $record) {
            // dd($record);
            $entity = $this->createEntity($record);
            // dd($entity);
            $this->entityManager->persist($entity);

            // Progress Bar +1
            $io->progressAdvance();
        }

        try {
            // Flush
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
        $io->text('From Database : Setting Blueprint');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Star1', 'Star2', 'Star3', 'Star4', 'Star5', 'Star6', 'Total']);
            foreach ($rows as $row) {
                $csv->insertOne([$row->getStar1(), $row->getStar2(), $row->getStar3(), $row->getStar4(), $row->getStar5(), $row->getStar6(), $row->getTotal()]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): SettingBlueprint
    {
        $entity = new SettingBlueprint();
        $entity
            ->setStar1($datas['Star1'])
            ->setStar2($datas['Star2'])
            ->setStar3($datas['Star3'])
            ->setStar4($datas['Star4'])
            ->setStar5($datas['Star5'])
            ->setStar6($datas['Star6'])
        ;

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'settings' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--blueprint.csv' : 'blueprint.csv');
    }
}
