<?php

declare(strict_types=1);

namespace App\Command\Cron\Count;

use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:count:tag',
    description: 'Compte le nombre de voitures par Tag',
    aliases: ['asphalt-cron-count-tag'],
    hidden: false,
)]
class TagCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Counter Tag :::::';

    protected static string $help  = 'Compte le nombre de voitures par Tag';

    public function __construct(
		private readonly EntityManagerInterface   $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
