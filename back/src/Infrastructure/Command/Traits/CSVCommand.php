<?php

namespace App\Infrastructure\Command\Traits;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Command\Helpers\Directory;
use App\Infrastructure\Data\CSV;

Trait CSVCommand
{
    private function export(string $root): void
    {
        /** Start Export */
        ### Get Datas from Database
        $rows = $this->repository->export();

        ### Make Directory
        $path = Directory::makeDirectory($root, $this->getFolder(), true);

        ### Get FilePath
        $csv = Directory::normalize($path . $this->getFile());

        ### Make File
        try {
            CSV::toFile($csv, $this->getHeader(), $rows);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création du CSV');
            $this->logger->error('CSV : ' . $this->getFile());
            $this->logger->error($e->getMessage());
        }
        /** End Export */
    }
}
