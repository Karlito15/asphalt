<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\GarageUpgrade;
use App\Repository\GarageUpgradeRepository;
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

class UpgradeService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageUpgradeRepository  $repository,
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
        $io->text('From CSV : Garage Upgrade');

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
        $io->text('From Database : Garage Upgrade');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Speed', 'Acceleration', 'Handly', 'Nitro', 'Common', 'Rare', 'Epic', 'Brand', 'Model']);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getSpeed(), $row->getAcceleration(), $row->getHandly(), $row->getNitro(),
                    $row->getCommon(), $row->getRare(), $row->getEpic(),
                    $row->getGarage()->getSettingBrand()->getName(), $row->getGarage()->getModel(),
                ]);
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): GarageUpgrade
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageUpgrade();
        $entity->setSpeed((int) $datas['Speed']);
        $entity->setAcceleration((int) $datas['Acceleration']);
        $entity->setHandly((int) $datas['Handly']);
        $entity->setNitro((int) $datas['Nitro']);
        $entity->setCommon((int) $datas["Common"]);
        $entity->setRare((int) $datas["Rare"]);
        $entity->setEpic((int) $datas["Epic"]);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'garages' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--upgrade.csv' : 'upgrade.csv');
    }
}
