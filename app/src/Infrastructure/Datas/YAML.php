<?php

declare(strict_types=1);

namespace App\Infrastructure\Datas;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml as SymfonyYaml;

final class YAML
{
    /**
     * Parses a YAML file into a PHP value.
     *
     * @param string $filepath  The path to the YAML file to be parsed
     * @param int $flags        A bit field of PARSE_* constants to customize the YAML parser behavior
     * @return mixed            The YAML converted to a PHP value
     */
    public static function FileToArray(string $filepath, int $flags = 0): mixed
    {
        try {
            return SymfonyYaml::parseFile($filepath, $flags);
        } catch (ParseException $exception) {
            throw new ParseException($exception->getMessage());
        }
    }

    /**
     * Convert an array to a yaml file.
     *
     * @param string $filepath  The path to the YAML file to be parsed
     * @param array $content
     * @param bool $regenerate
     * @return string
     */
    public static function ArrayToFile(string $filepath, array $content, bool $regenerate = true): string
    {
        try {
            $yaml = SymfonyYaml::dump($content);

            if ($regenerate) {
                file_put_contents($filepath, $yaml);
            } else {
                file_put_contents($filepath, $yaml, FILE_APPEND);
            }

            return $yaml;
        } catch (ParseException $exception) {
            throw new ParseException($exception->getMessage());
        }
    }
}
