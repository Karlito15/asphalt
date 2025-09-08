<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\GarageBlueprint;
use App\Repository\GarageBlueprintRepository;
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

class BlueprintService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageBlueprintRepository  $repository,
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
        $io->text('From CSV : Garage Blueprint');

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
        $io->text('From Database : Garage Blueprint');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Star1', 'Star2', 'Star3', 'Star4', 'Star5', 'Star6', 'Total', 'Brand', 'Model']);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getStar1(), $row->getStar2(), $row->getStar3(), $row->getStar4(), $row->getStar5(), $row->getStar6(), $row->getTotal(),
                    $row->getGarage()->getSettingBrand()->getName(), $row->getGarage()->getModel(),
                ]);
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): GarageBlueprint
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageBlueprint();
        $entity->setStar1($datas['Star1']);
        $entity->setStar2(self::convertStringToInteger($datas['Star2']));
        $entity->setStar3(self::convertStringToInteger($datas['Star3']));
        $entity->setStar4(self::convertStringToInteger($datas['Star4']));
        $entity->setStar5(self::convertStringToInteger($datas['Star5']));
        $entity->setStar6(self::convertStringToInteger($datas['Star6']));
        $entity->setGarage($garage);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'garages' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--blueprint.csv' : 'blueprint.csv');
    }
}
