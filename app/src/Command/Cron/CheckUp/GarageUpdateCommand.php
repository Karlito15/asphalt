<?php

namespace App\Command\Cron\CheckUp;

use App\Event\Garage\AppUpdateEvent;
use App\Persistence\Entity\GarageApp;
use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:checkup:garage',
    description: 'Mets à jour la Voiture',
    aliases: ['asphalt-cron-checkup-garage'],
    hidden: false,
)]
class GarageUpdateCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: CheckUp Status :::::';

    protected static string $help  = 'Mets à jour la Voiture';

    public function __construct(
		private readonly EntityManagerInterface   $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io        = new SymfonyStyle($input, $output);
        $manager   = $this->entityManager;
        $stopwatch = $this->stopwatch;

        // Execution time : start
        $stopwatch->start(self::$title);

        // Get Datas
        $garages   = $manager->getRepository(GarageApp::class)->findAll();

        // Progress Bar : Star
        $io->progressStart(count($garages));
        $io->newLine();
        foreach ($garages as $garage) {
            // Event
            $this->dispatcher->dispatch(new AppUpdateEvent($garage));

            // Progress Bar : +1
            $io->progressAdvance();
        }

        // Flush
        $manager->flush();

        // Progress Bar : Stop
        $io->progressFinish();

        // Execution time : stop
        $event      = $stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        return Command::SUCCESS;
    }
}
