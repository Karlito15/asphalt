<?php

declare(strict_types=1);

namespace App\Able\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

trait InitializeAble
{
    protected SymfonyStyle $io;

    protected Stopwatch $stopwatch;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        /** Options : Init */
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        /** Variables : Init */
        $this->io        = new SymfonyStyle($input, $output);
        $this->stopwatch = new Stopwatch(true);

        // /** Clear Screen */
        // $output->writeln(shell_exec('clear'));
        // system('clear');
    }
}
