<?php

declare(strict_types=1);

namespace App\Service\Command;

use KarlitoWeb\Toolbox\System\Path;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

final class PathService
{
    /**
     * @param string $folder
     * @return string
     */
    public static function getLastDirectory(string $folder): string
    {
        // Init
        $finder = new Finder();

        // Find directories
        $directories = $finder->directories()->in($folder)->depth(0);

        // Transforming Results into Arrays
        $array = iterator_to_array($directories->sortByName());

        // Get last value
        /** @var SplFileInfo $p */
        $result = array_last($array);

        return Path::canonicalize($result->getPathname()) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $root
     * @param string $directory
     * @param bool $addDate
     * @return string
     */
    public static function makeDirectory(string $root, string $directory, bool $addDate = false): string
    {
        $fs = new Filesystem();
        if ($addDate) {
            $datetime = new \DateTimeImmutable();
            $today    = $datetime->format('Y-m-d');
            $path     = Path::canonicalize($root . $today . DIRECTORY_SEPARATOR . $directory);
        } else {
            $path     = Path::canonicalize($root . DIRECTORY_SEPARATOR . $directory);
        }

        if (!$fs->exists($path)) {
            $fs->mkdir($path);
            $fs->chmod($path, 0775);
        }

        return $path . DIRECTORY_SEPARATOR;
    }
}
