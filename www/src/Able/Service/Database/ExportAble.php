<?php

declare(strict_types=1);

namespace App\Able\Service\Database;

use App\Able\Service\File\CSVAble;
use App\Able\Service\File\DirectoryAble;

trait ExportAble
{
    use CSVAble;
    use DirectoryAble;

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
