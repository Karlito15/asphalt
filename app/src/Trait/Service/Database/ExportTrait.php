<?php

declare(strict_types=1);

namespace App\Trait\Service\Database;

use App\Trait\Service\File\CSVTrait;
use App\Trait\Service\File\DirectoryTrait;

trait ExportTrait
{
    use CSVTrait;
    use DirectoryTrait;

    /** @return void */
    public function makeAnExport(): void
    {
        /** Get Datas from Database */
        $rows = $this->repository->exportDatas();

        /** Get Filepath */
        $csv = $this->getCSVFile(self::$file, self::$folder);

        /** Make File */
        self::writeFile($csv, $this->getHeader(), $rows);
    }
}
