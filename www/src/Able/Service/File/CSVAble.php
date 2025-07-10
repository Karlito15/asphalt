<?php

declare(strict_types=1);

namespace App\Able\Service\File;

use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use League\Csv\UnavailableStream;
use League\Csv\Writer;

trait CSVAble
{
    /**
     * @param string $filepath
     * @return TabularDataReader
     */
    public static function readFile(string $filepath): TabularDataReader
    {
        try {
            $reader = Reader::createFromPath($filepath, 'r');
            $reader->setHeaderOffset(0);
            $reader->setDelimiter(';');
            $reader->setEnclosure('"');
            $reader->setEscape('|');
            $stmt = (new Statement())->offset(0);

            return $stmt->process($reader);
        } catch (UnavailableStream|Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param string $filepath
     * @param array $header
     * @param array $datas
     * @return void
     */
    public static function writeFile(string $filepath, array $header, array $datas): void
    {
        try {
            $writer = Writer::createFromPath($filepath, 'w+');
            $writer->forceEnclosure();
            $writer->setDelimiter(';');
            $writer->setEndOfLine(PHP_EOL);
            $writer->setEscape('|');
            $writer->insertOne($header);
            $writer->insertAll($datas);
        } catch (UnavailableStream|CannotInsertRecord|Exception $e) {
            exit($e->getMessage());
        }
    }
}
