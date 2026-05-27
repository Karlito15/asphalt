<?php

declare(strict_types=1);

namespace App\Infrastructure\Data;

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
     * @param string $filepath
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @param bool $header
     * @return array<int, array<string, mixed>>
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    public static function toArray(
        string $filepath,
        string $delimiter = ";",
        string $enclosure = '"',
        string $escape = '|',
        bool   $header = true
    ): array
    {
        ### Read
        $records = self::reader($filepath, $delimiter, $enclosure, $escape, $header);

        ### Transform to Array
        $return = [];
        foreach ($records as $result)
        {
            $return[] = $result;
        }

        return $return;
    }

    /**
     * Return only the header of CSV
     *
     * @return array<string>
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws SyntaxError
     * @throws Exception
     */
    public static function getHeader(
        string $filepath,
        string $delimiter = ";",
        string $enclosure = '"',
        string $escape = '|',
        bool   $header = true
    ): array
    {
        return self::reader($filepath, $delimiter, $enclosure, $escape, $header)->getHeader();
    }

    /**
     * Exporte des données dans un fichier CSV.
     *
     * @param string $filepath
     * @param array<int, string> $header
     * @param array<int, array<int|string, float|int|string|\Stringable|null>> $records
     * @param string $mode
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws CannotInsertRecord
     */
    public static function toFile(
        string $filepath,
        array $header,
        array $records,
        string $mode = 'w+'
    ): void
    {
        // Une sécurité pour s'assurer que $mode n'est jamais vide à l'exécution
        if ($mode === '') {
            throw new \InvalidArgumentException('Le mode ne peut pas être vide.');
        }

        $writer = Writer::from($filepath, $mode);
        $writer->setDelimiter(';');
        $writer->setEndOfLine(PHP_EOL);
        $writer->setEnclosure('"');
        $writer->setEscape('|');
        $writer->forceEnclosure();
        if (!empty($header)) {
            $writer->insertOne($header);
        }
        $writer->insertAll(new \ArrayIterator($records));
    }

    /** PRIVATE METHODS */

    /**
     * @param string $filepath
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     * @param bool $header
     * @return Reader<array<int, string>>
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     */
    private static function reader(
        string $filepath,
        string $delimiter,
        string $enclosure,
        string $escape,
        bool   $header,
    ): Reader
    {
        ### Init Reader
        $reader = Reader::from($filepath, 'r+');
        $reader->setDelimiter($delimiter);
        $reader->setEnclosure($enclosure);
        $reader->setEscape($escape);
        if ($header === true) {
            $reader->setHeaderOffset(0);
        }

        return $reader;
    }
}
