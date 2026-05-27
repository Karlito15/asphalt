<?php

declare(strict_types=1);

namespace App\Application\Command\Database;

use App\Infrastructure\Command\Traits\{
    ConfigureCommand,
    InitializeCommand,
    InteractCommand
};
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:database:purge',
    description: 'Purge la base de données',
    aliases: ['asphalt-database-purge'],
    hidden: false
)]
class PurgeCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand;

    protected static string $title = '::::: Truncate Tables :::::';

    protected static string $help  = 'Vider la base de données';


    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $em         = $this->entityManager;
        $connection = $em->getConnection();

        ### Excluded tables
        $excluded = [
            'messenger_messages',
            '__migrations__',
        ];

        ### Execution time : start
        $this->stopwatch->start(self::$title);

        ### Purge
        $purger = new ORMPurger($em, $excluded);
        $purger->purge();

        ### Execution time : stop
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        ### Resume
        // self::resume($this->io, $duration);

        ### Conclusion
        $io->comment('Execution Time : ' . $duration);
        $io->success('La base de données est vide');

        return Command::SUCCESS;
    }
}
