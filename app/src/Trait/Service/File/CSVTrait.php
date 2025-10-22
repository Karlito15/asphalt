<?php

declare(strict_types=1);

namespace App\Trait\Service\File;

use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\TabularDataReader;
use League\Csv\UnavailableStream;
use League\Csv\Writer;

trait CSVTrait
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
            return (new Statement())->offset(0)->process($reader);
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
            // add Formatter
            // CharsetConverter::addTo($writer, 'utf-8', 'iso-8859-15');
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
