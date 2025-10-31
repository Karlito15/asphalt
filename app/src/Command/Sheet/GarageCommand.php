<?php

namespace App\Command\Sheet;

use App\Entity\GarageApp;
use App\Service\Command\Sheet\GarageService;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use App\Trait\Command\ResumeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:sheet:garage',
    description: "Exporte toutes les fiches du garage",
    aliases: ['asphalt-sheet-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use ResumeTrait;

    protected static string $title = '::::: Export Sheets Garage :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $manager,
        private readonly GarageService          $service,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io = new SymfonyStyle($input, $output);

        // Start
        $stopwatch = $this->stopwatch;
        $output->writeln(shell_exec('clear'));
        $this->io->title(self::$title);
        $io->section($this->getDescription());

        // Execution time : start
        $stopwatch->start(self::$title);

        // Step 01 : Get Datas
        $garages    = $this->manager->getRepository(GarageApp::class)->findAll();

        // Step 02 : Make Sheets
        $this->io->section('Make Sheets');

        // Progress Bar : Star
        $this->io->progressStart(count($garages));
        $this->io->newLine();
        foreach ($garages as $garage) {
            $this->service->create($garage);

            // Progress Bar : +1
            $this->io->progressAdvance();
            exit();
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
