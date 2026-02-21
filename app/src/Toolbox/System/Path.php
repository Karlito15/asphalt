<?php

declare(strict_types=1);

namespace App\Toolbox\System;

use Symfony\Component\Filesystem\Path as SymfonyPath;

final class Path
{
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
}
