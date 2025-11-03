<?php

declare(strict_types=1);

namespace App\Trait\Service\Database;

use App\Trait\Service\File\CSVTrait;
use App\Trait\Service\File\DirectoryTrait;
use Exception;
use Symfony\Component\Console\Style\SymfonyStyle;

trait ImportTrait
{
    use CSVTrait;
    use DirectoryTrait;

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function makeAnImport(SymfonyStyle $io): bool
    {
        // Get CSV File
        try {
            $csv = $this->getCSVFile(self::$file, self::$folder);
        } catch (Exception $e) {
            $this->logger->error('File not Recovered ! ' . self::$file);
            $this->logger->notice($e->getMessage());
        }

        // Read CSV
        if (isset($csv)) {
            $records = self::readFile($csv);

            // Progress Bar Start
            $io->progressStart($records->count());

            // Handling
            foreach ($records as $record) {
                $entity = $this->createEntity($record);
                $this->entityManager->persist($entity);

                // Progress Bar +1
                $io->progressAdvance();
            }

            try {
                // Progress Bar Stop
                $io->progressFinish();

                // Flush
                $this->entityManager->flush();
                $this->entityManager->clear();
                return true;
            } catch (Exception $e) {
                $this->logger->error(__FILE__ . ' : Erreur lors du flush : ' . $e->getMessage());
                return false;
            }
        } else {
            return false;
        }
    }
}
