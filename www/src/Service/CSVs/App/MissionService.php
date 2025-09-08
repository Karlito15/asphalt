<?php

namespace App\Service\CSVs\App;

use App\Able\CommandAble;
use App\Entity\AppMission;
use App\Entity\MissionTask;
use App\Entity\MissionType;
use App\Repository\AppMissionRepository;
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

class MissionService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly AppMissionRepository       $repository,
    )
    {}

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function import(SymfonyStyle $io): bool
    {
        // Init
        $io->text('From CSV : App Mission');

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
        $io->text('From Database : App Mission');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Week', 'Region', 'Track', 'Class', 'Brand', 'Description', 'Success', 'Target', 'Task', 'Type']);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getWeek(), $row->getRegion(), $row->getTrack(), $row->getClass(),
                    $row->getBrand(), $row->getDescription(), $row->getSuccess(), $row->getTarget(),
                    $row->getTask()->getValue(), $row->getType()->getValue()
                ]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): AppMission
    {
        $entity = new AppMission();
        $entity->setWeek((int) $datas['Week']);
        $entity->setRegion(($datas['Region'] != "") ? (string) $datas['Region'] : NULL);
        $entity->setTrack(($datas['Track'] != "") ? (string) $datas['Track'] : NULL);
        $entity->setClass(($datas['Class'] != "") ? (string) $datas['Class'] : NULL);
        $entity->setBrand(($datas['Brand'] != "") ? (string) $datas['Brand'] : NULL);
        $entity->setDescription(($datas['Description'] != "") ? (string) $datas['Description'] : NULL);
        $entity->setSuccess((int) $datas['Success']);
        $entity->setTarget((int) $datas['Target']);
        $entity->setTask($this->entityManager->getRepository(MissionTask::class)->findOneBy(['value' => $datas['Task']]));
        $entity->setType($this->entityManager->getRepository(MissionType::class)->findOneBy(['value' => $datas['Type']]));

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'missions' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--app-mission.csv' : 'app-mission.csv');
    }
}
