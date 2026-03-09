<?php

declare(strict_types=1);

namespace App\Command\Cron\Count;

use App\Event\Setting\BrandEvent;
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
    name: 'asphalt:cron:count:brand',
    description: 'Compte le nombre de voitures par Marque',
    aliases: ['asphalt-cron-count-brand'],
    hidden: false,
)]
class BrandCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Counter Brand :::::';

    protected static string $help  = 'Compte le nombre de voitures par Marque';

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
            $this->dispatcher->dispatch(new BrandEvent($garage));

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
        self::resume($io, $duration);

        return Command::SUCCESS;
    }
}
