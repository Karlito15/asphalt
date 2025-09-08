<?php

namespace App\Able;

use App\Entity\AppGarage;
use App\Entity\SettingBrand;
use League\Csv\CharsetConverter;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\SyntaxError;
use League\Csv\TabularDataReader;
use League\Csv\UnavailableStream;
use League\Csv\Writer;

trait ServiceAble
{
    /**
     * Lis un fichier CSV
     *
     * @param string $file
     * @return TabularDataReader
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws SyntaxError
     */
    public static function readCSV(string $file): TabularDataReader
    {
        /** Encoding : iso-8859-15 | utf-8 */
        $encoder = (new CharsetConverter())->inputEncoding('iso-8859-15')->outputEncoding('utf-8');

        // Read CSV File
        $csv = Reader::createFromPath($file, 'r');
        // set the CSV header offset
        $csv->setHeaderOffset(0);
        // set Delimiter
        $csv->setDelimiter(';');
        // add Formatter
        $csv->addFormatter($encoder);

        $stmt = (new Statement())->offset(0);

        return $stmt->process($csv);
    }

    /**
     * Crée un fichier CSV
     *
     * @param string $filepath
     * @return Writer
     */
    public static function createCSV(string $filepath): Writer
    {
        try {
            // Write CSV File
            $csv = Writer::createFromPath($filepath, 'w+');
            // add Formatter
            CharsetConverter::addTo($csv, 'utf-8', 'iso-8859-15');
            // set Delimiter
            $csv->setDelimiter(';');
        } catch (UnavailableStream|InvalidArgument $e) {
            echo $e->getLine() . ' | ' . $e->getMessage();
        }

        return $csv;
    }

    private static function convertStringToInteger(?string $value = null):int
    {
        return ($value === null) ? 0 : (int) $value;
    }

    private function findGarage(string $brand, string $model): AppGarage
    {
        /** @var AppGarage $garage */
        $brandEntity = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $brand]);
        $garage      = $this->entityManager->getRepository(AppGarage::class)->findOneBy(['model' => $model, 'settingBrand' => $brandEntity]);
        if (is_null($garage)) {
            echo ' /!\ ' . $brand . ' ' . $model . ' /!\ ';
            exit();
        }

        return $garage;
    }
}
