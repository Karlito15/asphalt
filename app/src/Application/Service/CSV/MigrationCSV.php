<?php

declare(strict_types=1);

namespace App\Application\Service\CSV;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Datas\CSV;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;

trait MigrationCSV
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
            ### Read CSV File
            $records = CSV::FileToArray($filepath);

            ### Progress Bar Start
            $io->progressStart(count($records));

            ### Handling
            foreach ($records as $record) {
                ### Progress Bar +1
                $io->progressAdvance();

                ### Create Entity
                $entity = $this->createEntity($record);

                ### Persist Entity
                $this->entityManager->persist($entity);
            }

            ### Progress Bar Stop
            $io->progressFinish();

            ### Flush
            $connection = $this->entityManager->getConnection();
            $connection->beginTransaction();
            try {
                $this->entityManager->flush();
                $this->entityManager->clear();
                $connection->commit();
            } catch (\Exception $e) {
                $io->newLine(3);
                $this->logger->error('Erreur lors du flush');
                $this->logger->error($e->getMessage());
                $this->logger->error('CSV : ' . $filepath);
                ### Rollback
                $connection->rollback();
            }
        } else {
            $io->newLine(3);
            $io->error($filepath);
            $this->logger->error('CSV File does not exist');
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
        ### Get Datas from Database
        $rows = $this->repository->export();

        ### Make Directory
        $path = Folder::makeDirectory($root, $this->getFolder(), true);

        ### Get FilePath
        $csv = Folder::normalize($path . $this->getFile());

        ### Make File
        try {
            CSV::ArrayToFile($csv, $this->getHeader(), $rows);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création du CSV');
            $this->logger->error($e->getMessage());
            $this->logger->error('CSV : ' . $csv);
        }
    }

    /**
     * @param array $datas
     * @return GarageApp
     */
    public function findGarage(array $datas): GarageApp
    {
        if (is_null($datas['Brand'])) {
            throw new \RuntimeException('Brand cannot be null :: ' . $datas['Brand']);
        }

        if (is_null($datas['Model'])) {
            throw new \RuntimeException('Model cannot be null :: ' . $datas['Brand']);
        }

        return $this->entityManager->getRepository(GarageApp::class)->findByBrandAndModel($datas['Brand'], $datas['Model']);
    }
}
