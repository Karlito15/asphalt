<?php

declare(strict_types=1);

namespace App\Service\Command;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use Doctrine\DBAL\Exception;
use KarlitoWeb\Toolbox\File\CSV;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

trait MigrationService
{
    /**
     * Exporte les données d'une entité dans un fichier CSV
     *
     * @param string $root
     * @return void
     */
    public function makeAnExport(string $root): void
    {
        // Get Datas from Database
        $rows = $this->repository->export();

        // Get FolderPath
        $path = PathService::makeDirectory($root, self::$folder, true);

        // Get FilerPath
        $csv = $path . DIRECTORY_SEPARATOR . self::$file;

        // Make File
        try {
            CSV::ArrayToFile($csv, $this->getHeader(), $rows);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création du CSV');
            $this->logger->error($e->getMessage());
            $this->logger->error('Class : ' . __CLASS__);
            $this->logger->error('CSV   : ' . $csv);
        }
    }

    /**
     * Importe les données d'une entité depuis un fichier CSV
     *
     * @param SymfonyStyle $io
     * @param string $filepath
     * @throws Exception
     */
    public function makeAnImport(SymfonyStyle $io, string $filepath): void
    {
        $fs = new Filesystem();

        if ($fs->exists($filepath)) {
            // Read CSV File
            $records = CSV::FileToArray($filepath);

            // Progress Bar Start
            $io->progressStart(count($records));

            // Handling
            foreach ($records as $record) {
                // Progress Bar +1
                $io->progressAdvance();

                // Create Entity
                $entity = $this->createEntity($record);

                // Persist Entity
                $this->entityManager->persist($entity);
            }

            // Progress Bar Stop
            $io->progressFinish();

            $connection = $this->entityManager->getConnection();
            $connection->beginTransaction();
            try {
                // Flush
                $this->entityManager->flush();
                $this->entityManager->clear();
                $connection->commit();
            } catch (\Exception $e) {
                $io->newLine(3);
                $this->logger->error('Erreur lors du flush');
                $this->logger->error($e->getMessage());
                $this->logger->error('Class : ' . __CLASS__);
                $this->logger->error('CSV   : ' . $filepath);
                // Rollback
                $connection->rollback();
            }
        } else {
            throw new \RuntimeException('CSV File does not exist');
        }
    }

    /**
     * @param string $brand
     * @param string $model
     * @return GarageApp
     */
    public function findGarage(string $brand, string $model): GarageApp
    {
        $settingBrand = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $brand]);
        $garage       = $this->entityManager->getRepository(GarageApp::class)->findOneBy(['model' => $model, 'settingBrand' => $settingBrand]);

        if (is_null($garage)) {
            echo PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;
            $this->logger->error($brand);
            $this->logger->error($model);
            exit;
        }

        return is_null($garage) ? throw new \RuntimeException(sprintf(' /!\ %1$s %2$s /!\ ', $brand, $model)) : $garage;
    }

    /**
     * @param string|null $value
     * @return int
     */
    public function convertStringToInteger(?string $value = null): int
    {
        return ($value === null) ? 0 : (int) $value;
    }
}
