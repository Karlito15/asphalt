<?php

namespace App\Service\CSVs\Setting;

use App\Able\CommandAble;
use App\Entity\SettingUnitPrice;
use App\Repository\SettingUnitPriceRepository;
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

class UnitPriceService implements ServiceInterface
{
    use ServiceAble;
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingUnitPriceRepository $repository,
    ) {}

    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function import(SymfonyStyle $io): bool
    {
        // Init
        $io->text('From CSV : Setting Unit Price');

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
        $io->text('From Database : Setting Unit Price');

        try {
            $rows = $this->repository->findAll();
            $file = $this->getCSVFile();
            $csv  = self::createCSV($file);
            // Insert each line
            $csv->insertOne([
				'Level01', 'Level02', 'Level03', 'Level04',
	            'Level05', 'Level06', 'Level07', 'Level08',
	            'Level09', 'Level10', 'Level11', 'Level12',
	            'Level13', 'Common', 'Rare', 'Epic'
            ]);
            foreach ($rows as $row) {
                $csv->insertOne([
                    $row->getLevel01(), $row->getLevel02(), $row->getLevel03(), $row->getLevel04(),
                    $row->getLevel05(), $row->getLevel06(), $row->getLevel07(), $row->getLevel08(),
                    $row->getLevel09(), $row->getLevel10(), $row->getLevel11(), $row->getLevel12(),
                    $row->getLevel13(), $row->getCommon(), $row->getRare(), $row->getEpic(),
                ]);
            }
        } catch (InvalidArgument|CannotInsertRecord $e) {
            echo $e->getLine();
        }
    }

    public function createEntity(array $datas): SettingUnitPrice
    {
        $entity = new SettingUnitPrice();
        $entity
            ->setLevel01($datas['Level01'])
            ->setLevel02($datas['Level02'])
            ->setLevel03($datas['Level03'])
            ->setLevel04($datas['Level04'])
            ->setLevel05($datas['Level05'])
            ->setLevel06($datas['Level06'])
            ->setLevel07($datas['Level07'])
            ->setLevel08($datas['Level08'])
            ->setLevel09($datas['Level09'])
            ->setLevel10($datas['Level10'])
        ;
        ($datas['Level11'] === '') ? $entity->setLevel11(null) : $entity->setLevel11($datas['Level11']) ; // $datas['Level11'] != '0' OR
        ($datas['Level12'] === '') ? $entity->setLevel12(null) : $entity->setLevel12($datas['Level12']) ; // $datas['Level12'] != '0' OR
        ($datas['Level13'] === '') ? $entity->setLevel13(null) : $entity->setLevel13($datas['Level13']) ; // $datas['Level13'] != '0' OR
        $entity->setCommon($datas['Common']);
        $entity->setRare($datas['Rare']);
        $entity->setEpic($datas['Epic']);

        return $entity;
    }

    public function getCSVFile(): string
    {
        $d = $this->getCSVDirectory() . 'settings' . DIRECTORY_SEPARATOR;
        $e = $this->getEnvironment();

        return $d. (($e === 'dev') ? 'dev--unit-price.csv' : 'unit-price.csv');
    }
}
