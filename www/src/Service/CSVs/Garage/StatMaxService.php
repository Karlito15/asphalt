<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\GarageStatMax;
use App\Repository\GarageStatMaxRepository;
use App\Able\ServiceAble;
use App\Interface\ServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StatMaxService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatMaxRepository    $repository,
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
        $io->text('From CSV : Garage Stat Max');

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
        $io->text('From Database : Garage Stat Max');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Speed', 'Acceleration', 'Handly', 'Nitro', 'Average', 'Brand', 'Model']);
            foreach ($rows as $row) {
                $csv->insertOne(
                    [
                        $row->getSpeed(), $row->getAcceleration(), $row->getHandly(), $row->getNitro(), $row->getAverage(),
                        $row->getGarage()->getSettingBrand()->getName(), $row->getGarage()->getModel(),
                    ]
                );
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): GarageStatMax
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatMax();
        $entity->setSpeed((float) $datas['Speed']);
        $entity->setAcceleration((float) $datas['Acceleration']);
        $entity->setHandly((float) $datas['Handly']);
        $entity->setNitro((float) $datas['Nitro']);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'garages' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--stat-max.csv' : 'stat-max.csv');
    }
}
