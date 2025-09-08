<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\AppGarage;
use App\Entity\SettingLevel;
use App\Repository\AppGarageRepository;
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

class GarageLevelService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly AppGarageRepository        $repository,
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
        $io->text('From CSV : App Garage Level');

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
        $io->text('From Database : App Garage Level');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Brand', 'Model', 'SettingLevel']);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getSettingBrand()->getName(),
                    $row->getModel(),
                    $row->getSettingLevel()->getSlug(),
                ]);
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): AppGarage
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        // $str    = str_replace("'", null, $datas['SettingLevel']);
        $level  = $this->entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => $datas['SettingLevel']]);
        $garage->setSettingLevel($level);

        return $garage;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'garages' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--app-garage-level.csv' : 'app-garage-level.csv');
    }
}
