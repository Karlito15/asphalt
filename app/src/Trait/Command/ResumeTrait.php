<?php

declare(strict_types=1);

namespace App\Trait\Command;

use Symfony\Component\Console\Style\SymfonyStyle;

trait ResumeTrait
{
    /**
     * Display the resume of CLI Command
     *
     * @param SymfonyStyle $io
     * @param float        $duration
     */
    public static function resume(SymfonyStyle $io, float $duration = 0.0): void
    {
        $io->newLine(2);
        $io->section('Resume');
        /* Execution Time */
        $time      = ($duration > 180) ? round($duration / 60) . ' min.' : $duration . ' sec.';
        /* Currently used memory */
        $mem_usage = memory_get_usage();
        /* Peak memory usage */
        $mem_peak  = memory_get_peak_usage();
        /**
         * black, blue, bright-blue, bright-cyan, bright-green, bright-magenta, bright-red, bright-whit, bright-yellow, cyan,
         * default, gray, green, magenta, red, white, yellow
         */
        $io->text([
            '<fg=white;bg=bright-green;>Execution Time      :      '               . $time . '</>',
            '<fg=white;bg=gray;>The script is using : ' . round($mem_usage / 1048576) . ' MB of memory.</>',
            '<fg=white;bg=gray;>Peak usage          : ' . round($mem_peak / 1048576) . ' MB of memory.</>',
        ]);
    }
}
