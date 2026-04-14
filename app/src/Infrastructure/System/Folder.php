<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path as SymfonyPath;
use Symfony\Component\Finder\Finder;

final class Folder
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

        ### Prefix directory with date
        if ($addDate) {
            $datetime = new \DateTimeImmutable();
            $today    = $datetime->format('Y-m-d');
            $path     = Folder::canonicalize($root . $today . DIRECTORY_SEPARATOR . $directory);
        } else {
            $path     = Folder::canonicalize($root . DIRECTORY_SEPARATOR . $directory);
        }

        ### Make Directory if not exist
        if (!$fs->exists($path)) {
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
        return SymfonyPath::canonicalize($path);
    }

    /**
     * Normalizes the given path.
     *
     * @param string $path
     * @return string
     */
    public static function normalize(string $path): string
    {
        return SymfonyPath::normalize($path);
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
