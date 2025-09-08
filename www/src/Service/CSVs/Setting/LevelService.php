<?php

namespace App\Service\CSVs\Setting;

use App\Able\CommandAble;
use App\Entity\SettingLevel;
use App\Repository\SettingLevelRepository;
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

class LevelService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingLevelRepository $repository,
    ) {}

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function import(SymfonyStyle $io): bool
    {
        // Init
        $io->text('From CSV : Setting Level');

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

    public function export(SymfonyStyle $io): void
    {
        // Init
        $io->text('From Database : Setting Level');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne(['Level', 'Common', 'Rare', 'Epic']);
            foreach ($rows as $row) {
                $csv->insertOne([$row->getLevel(), $row->getCommon(), $row->getRare(), $row->getEpic()]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): SettingLevel
    {
        $entity = new SettingLevel();
        $entity
            ->setLevel($datas['Level'])
            ->setCommon($datas['Common'])
            ->setRare($datas['Rare'])
            ->setEpic($datas['Epic'])
        ;

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'settings' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--level.csv' : 'level.csv');
    }
}
