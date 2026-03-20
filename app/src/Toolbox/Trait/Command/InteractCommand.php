<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait InteractCommand
{
    /**
     * Start Command
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $this->io->title(static::$title . ' ' . static::$help);
    }
}
