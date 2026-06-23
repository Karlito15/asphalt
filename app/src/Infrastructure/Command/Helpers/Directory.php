<?php

declare(strict_types=1);

namespace App\Infrastructure\Command\Helpers;

use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;

final class Directory
{
    /**
     * Retourne le dernier dossier
     *
     * @param string $folder
     * @return string
     */
    public static function getLastDirectory(string $folder): string
    {
        ### Init
        $finder = new Finder();

        ### Find directories
        $directories = $finder->directories()->in($folder)->depth(0);

        ### Transforming Results into Arrays
        $array = iterator_to_array($directories->sortByName());

        ### Get last value
        $result = array_last($array);

        return self::canonicalize($result->getPathname()) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $root
     * @param string $directory
     * @param bool $addDate
     * @return string
     */
    public static function makeDirectory(string $root, string $directory, bool $addDate = false): string
    {
        ### Init
        $fs = new Filesystem();

        if ($addDate) {
            ### Prefix directory with date
            $datetime = new DateTimeImmutable();
            $today    = $datetime->format('Y-m-d');
            $path     = self::canonicalize($root . $today . DIRECTORY_SEPARATOR . $directory);
        } else {
            $path     = self::canonicalize($root . DIRECTORY_SEPARATOR . $directory);
        }

        if (!self::isExists($path)) {
            ### Create Directory
            $fs->mkdir($path);
            $fs->chmod($path, 0775);
        }

        return $path . DIRECTORY_SEPARATOR;
    }

    /**
     * Returns the shortest path name equivalent to the given path.
     *
     * @param string $path
     * @return string
     */
    public static function canonicalize(string $path): string
    {
        return Path::canonicalize($path);
    }

    /**
     * Normalizes the given path.
     *
     * @param string $path
     * @return string
     */
    public static function normalize(string $path): string
    {
        return Path::normalize($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public static function isExists(string $path): bool
    {
        return (new Filesystem())->exists($path);
    }
}
