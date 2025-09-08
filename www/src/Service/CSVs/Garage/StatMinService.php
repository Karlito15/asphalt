<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\GarageStatMin;
use App\Repository\GarageStatMinRepository;
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

class StatMinService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatMinRepository    $repository,
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
        $io->text('From CSV : Garage Stat Min');

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
        $io->text('From Database : Garage Stat Min');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Speed', 'Acceleration', 'Handly', 'Nitro', 'Brand', 'Model']);
            foreach ($rows as $row) {
                $csv->insertOne(
                    [
                        $row->getSpeed(), $row->getAcceleration(), $row->getHandly(), $row->getNitro(),
                        $row->getGarage()->getSettingBrand()->getName(), $row->getGarage()->getModel(),
                    ]
                );
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): GarageStatMin
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatMin();
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

        return $d. (($e === 'dev') ? 'dev--stat-min.csv' : 'stat-min.csv');
    }
}
