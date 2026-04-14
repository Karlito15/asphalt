<?php

declare(strict_types=1);

namespace App\Application\Service\Command;

use DateTimeImmutable;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

trait InitializeCommand
{
    protected SymfonyStyle $io;

    protected Stopwatch $stopwatch;

    protected DateTimeImmutable $date;

    /**
     * Initialise la commande, les variable $io, $stopwatch & $date
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        /** PHP Config */
        ini_set("memory_limit", "-1");
        set_time_limit(0);

        /** Init Variables */
        $this->io        = new SymfonyStyle($input, $output);
        $this->stopwatch = new Stopwatch(true);
        $this->date      = new DateTimeImmutable();
    }
}
