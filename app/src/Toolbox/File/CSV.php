<?php

declare(strict_types=1);

namespace App\Toolbox\File;

use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;
use League\Csv\Writer;

final class CSV
{
    /**
     * Transform a CSV File to an array
     *
     * @param string $filepath
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @param bool $header
     * @return array
     */
    public static function FileToArray(
         string $filepath,
         string $delimiter = ";", // \n
         string $enclosure = '"',
         string $escape = '|',
         bool   $header = true
    ): array
    {
        /** Array */
        $return  = [];

        /** Reader */
        try {
            $reader = Reader::from($filepath, 'r');
            $reader->setDelimiter($delimiter);
            $reader->setEnclosure($enclosure);
            $reader->setEscape($escape);
            if ($header === true) {
                $reader->setHeaderOffset(0);
            }
            $records = $reader->getRecords();
        } catch (UnavailableStream|InvalidArgument|SyntaxError|Exception $e) {
            echo $e->getMessage();
            $records = [];
        }

        foreach ($records as $result) {
            $return[] = $result;
        }

        return $return;
    }

    /**
     * Transform an array to a CSV File
     *
     * @param string $filepath
     * @param array $header
     * @param array $datas
     * @param string $mode
     * @return bool
     */
    public static function ArrayToFile(
        string $filepath,
        array $header,
        array $datas,
        string $mode = 'w+'
    ): bool
    {
        /** Reader */
        try {
            $writer = Writer::from($filepath, $mode);
            $writer->setDelimiter(';');
            $writer->setEscape('|');
            $writer->setEndOfLine(PHP_EOL);
            // $writer->forceEnclosure();
            $writer->insertOne($header);
            $writer->insertAll($datas);

            return true;
        } catch (UnavailableStream|CannotInsertRecord|Exception $e) {
            echo $e->getMessage();
        }

        return false;
    }
}
