<?php

declare(strict_types=1);

namespace App\Application\Service\Command;

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
     * @return string
     */
    public static function makeDirectory(string $root, string $directory): string
    {
        $fs       = new Filesystem();
        $datetime = new \DateTimeImmutable();
        $today    = $datetime->format('Y-m-d');
        $rootPath = $root . $today;
        $path     = Path::canonicalize($rootPath . DIRECTORY_SEPARATOR . $directory);

        if (!$fs->exists($path)) {
            $fs->mkdir($path);
            $fs->chmod($path, 0775);
        }

        return $path;
    }
}
