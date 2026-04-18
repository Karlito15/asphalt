<?php

declare(strict_types=1);

namespace App\Application\Command\Cron\CheckUp;

use App\Application\Event\Garage\AppUpdateGauntletEvent;
use App\Application\Service\Command\AllCommand;
use App\Domain\Entity\GarageApp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:garage:gauntlet',
    description: 'Mets à jour la Voiture',
    aliases: ['asphalt-cron-checkup-garage'],
    hidden: false,
)]
class GarageGauntletCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: CheckUp Status :::::';

    protected static string $help  = '';

    public function __construct(
		private readonly EntityManagerInterface   $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init Variables
        $io         = new SymfonyStyle($input, $output);
        $manager    = $this->entityManager;
        $stopwatch  = $this->stopwatch;
        $dispatcher = $this->dispatcher;

        ### Execution time : start
        $stopwatch->start(self::$title);

        ### Get Datas
        $garages   = $manager->getRepository(GarageApp::class)->findAll();

        ### Progress Bar : Star
        $io->progressStart(count($garages));
        $io->newLine();
        foreach ($garages as $garage) {
            ### Event
            $dispatcher->dispatch(new AppUpdateGauntletEvent($garage));

            ### Progress Bar : +1
            $io->progressAdvance();
        }

        ### Flush
        $manager->flush();

        ### Progress Bar : Stop
        $io->progressFinish();

        ### Execution time : stop
        $event      = $stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        ### Resume
        self::resume($this->io, $duration);

        return Command::SUCCESS;
    }
}
