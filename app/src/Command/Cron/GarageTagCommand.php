<?php

declare(strict_types=1);

namespace App\Command\Cron;

use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:cron:tag',
    description: '...',
    aliases: ['asphalt-cron-tag'],
    hidden: false,
)]
class GarageTagCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Tags :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io = new SymfonyStyle($input, $output);

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
