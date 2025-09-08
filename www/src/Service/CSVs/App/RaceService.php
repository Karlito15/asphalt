<?php

namespace App\Service\CSVs\App;

use App\Able\CommandAble;
use App\Entity\AppRace;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use App\Entity\RaceTrack;
use App\Repository\AppRaceRepository;
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

class RaceService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly AppRaceRepository          $repository,
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
        $io->text('From CSV : App Race');

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
        $io->text('From Database : App Race');
        $csv = $this->getCSVFile();
        try {
            $rows = $this->repository->findBy([], ['season' => 'ASC', 'raceOrder' => 'ASC']);
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Season', 'RaceOrder', 'Mode', 'Time', 'English']);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getSeason()->getName(), $row->getRaceOrder(), $row->getMode()->getName(),
                    $row->getTime()->getName(), $row->getTrack()->getNameEnglish()
                ]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): AppRace
    {
        /** @var RaceMode $mode */
        $mode   = $this->entityManager->getRepository(RaceMode::class)->findOneBy(['name' => $datas['Mode']]);
        /** @var RaceSeason $season */
        $season = $this->entityManager->getRepository(RaceSeason::class)->findOneBy(['name' => $datas['Season']]);
        /** @var RaceTime $time */
        $time   = $this->entityManager->getRepository(RaceTime::class)->findOneBy(['name' => $datas['Time']]);
        /** @var RaceTrack $track */
        $track  = $this->entityManager->getRepository(RaceTrack::class)->findOneBy(['nameEnglish' => $datas['English']]);
        if ($track === null) {
            echo $datas['NameEnglish'];
            exit();
        }
        $entity = new AppRace();
        $entity
            ->setRaceOrder((int) $datas['RaceOrder'])
            ->setFinished(true)
            ->setMode($mode)
            ->setSeason($season)
            ->setTime($time)
            ->setTrack($track)
        ;

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'races' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--app-race.csv' : 'app-race.csv');
    }
}
