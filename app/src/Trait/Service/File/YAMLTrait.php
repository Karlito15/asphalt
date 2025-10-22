<?php

declare(strict_types=1);

namespace App\Trait\Service\File;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

trait YAMLTrait
{
    /**
     * @param string $filepath
     * @return array
     */
    public static function readFile(string $filepath): array
    {
        $return = [];
        try {
            $return = Yaml::parseFile($filepath);
        } catch (ParseException $exception) {
            throw new ParseException($exception->getMessage());
        } finally {
            return $return;
        }
    }

    /**
     * @param string $filepath
     * @param array $datas
     * @return void
     */
    public static function writeFile(string $filepath, array $datas): void
    {
        try {
            file_put_contents($filepath, Yaml::dump($datas));
        } catch (ParseException $exception) {
            throw new ParseException($exception->getMessage());
        }
    }
}
