<?php

namespace App\Service\CSVs\Garage;

use App\Able\CommandAble;
use App\Entity\GarageBoolean;
use App\Repository\GarageBooleanRepository;
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

class BooleanService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageBooleanRepository    $repository,
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
        $io->text('From CSV : Garage Boolean');

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
        $io->text('From Database : Garage Boolean');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne([
                'Locked', 'FullBlueprint', 'Gold',
                'ToUnlock', 'ToUpgrade', 'ToGold',
                'InstallSpeed', 'FullSpeed', 'InstallAcceleration', 'FullAcceleration',
                'InstallHandly', 'FullHandly', 'InstallNitro', 'FullNitro',
                'InstallCommon', 'FullCommon', 'InstallRare', 'FullRare',
                'InstallEpic', 'FullEpic', 'Brand', 'Model'
            ]);
            foreach ($rows as $row) {
                $csv->insertOne([
                    (int) $row->isLocked(), (int) $row->isFullBlueprint(), (int) $row->isGold(),
                    (int) $row->isToUnlock(), (int) $row->isToUpgrade(), (int) $row->isToGold(),
                    (int) $row->isInstallSpeed(), (int) $row->isFullSpeed(), (int) $row->isInstallAcceleration(), (int) $row->isFullAcceleration(),
                    (int) $row->isInstallHandly(), (int) $row->isFullHandly(), (int) $row->isInstallNitro(), (int) $row->isFullNitro(),
                    (int) $row->isInstallCommon(), (int) $row->isFullCommon(), (int) $row->isInstallRare(), (int) $row->isFullRare(),
                    (int) $row->isInstallEpic(), (int) $row->isFullEpic(),
                    $row->getGarage()->getSettingBrand()->getName(), $row->getGarage()->getModel(),
                ]);
            }
        } catch (InvalidArgument $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): GarageBoolean
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageBoolean();
        $entity->setLocked($datas['Locked']);
        $entity->setFullBlueprint($datas['FullBlueprint']);
        $entity->setGold($datas['Gold']);
        $entity->setToUnlock($datas['ToUnlock']);
        $entity->setToUpgrade($datas['ToUpgrade']);
        $entity->setToGold($datas['ToGold']);
        $entity->setInstallSpeed($datas['InstallSpeed']);
        $entity->setFullSpeed($datas['FullSpeed']);
        $entity->setInstallAcceleration($datas['InstallAcceleration']);
        $entity->setFullAcceleration($datas['FullAcceleration']);
        $entity->setInstallHandly($datas['InstallHandly']);
        $entity->setFullHandly($datas['FullHandly']);
        $entity->setInstallNitro($datas['InstallNitro']);
        $entity->setFullNitro($datas['FullNitro']);
        $entity->setInstallCommon($datas['InstallCommon']);
        $entity->setFullCommon($datas['FullCommon']);
        $entity->setInstallRare($datas['InstallRare']);
        $entity->setFullRare($datas['FullRare']);
        $entity->setInstallEpic($datas['InstallEpic']);
        $entity->setFullEpic($datas['FullEpic']);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'garages' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--boolean.csv' : 'boolean.csv');
    }
}
