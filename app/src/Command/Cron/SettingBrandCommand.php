<?php

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Event\Setting\BrandEvent;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use App\Trait\Command\ResumeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:setting-brand',
    description: 'Compte le nombre de voitures par marque',
    aliases: ['asphalt-cron-setting-brand'],
    hidden: false,
)]
class SettingBrandCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use ResumeTrait;

    protected static string $title = '::::: Counter Brand :::::';

    public function __construct(
		private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io        = new SymfonyStyle($input, $output);
        $stopwatch = $this->stopwatch;
        $garages   = $this->entityManager->getRepository(GarageApp::class)->findAll();

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());
        $output->writeln(shell_exec('clear'));

        // Execution time : start
        $stopwatch->start(self::$title);

        // Progress Bar : Star
        $this->io->progressStart(count($garages));
        $this->io->newLine();
        foreach ($garages as $garage) {
            // Event
            $this->dispatcher->dispatch(new BrandEvent($garage));

            // Progress Bar : +1
            $this->io->progressAdvance();
        }

        // Progress Bar : Stop
        $this->io->progressFinish();

        // Execution time : stop
        $event      = $stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        return Command::SUCCESS;
    }
}
