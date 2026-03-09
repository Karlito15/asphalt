<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Command;

use App\Persistence\Entity\GarageApp;
use App\Service\Command\PathService;
use App\Toolbox\File\CSV;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

trait MigrationCommand
{
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
     * @param string $brand
     * @param string $model
     * @return GarageApp
     */
    public function findGarage(array $datas): GarageApp
    {
        return $this->entityManager->getRepository(GarageApp::class)->findByBrandAndModel($datas['Brand'], $datas['Model']);
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
