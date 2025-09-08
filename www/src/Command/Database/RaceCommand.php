<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use App\Service\CSVs\App\RaceService;
use App\Service\CSVs\Race\ModeService;
use App\Service\CSVs\Race\RegionService;
use App\Service\CSVs\Race\SeasonService;
use App\Service\CSVs\Race\TimeService;
use App\Service\CSVs\Race\TrackService;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:database:race',
    description: 'Toutes les données pour les Courses',
    aliases: ['a:d:r', 'asphalt-database-race'],
    hidden: false,
)]
class RaceCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly ContainerInterface         $container,
        private readonly EntityManagerInterface     $entityManager,
        private readonly ModeService                $mode,
        private readonly RegionService              $region,
        private readonly SeasonService              $season,
        private readonly TimeService                $time,
        private readonly TrackService               $track,
        private readonly RaceService                $race,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
       // configure an argument
        $this->addArgument(
            'choice',
            InputArgument::OPTIONAL,
            'Export or Import Settings'
        );
    }

    /**
     * @throws Exception
     * @throws CannotInsertRecord
     * @throws UnavailableStream
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->section((string) self::getDefaultDescription());

        // Introduction
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        // Services
        if ($choice == 'import') {
            $this->mode->import($io);
            $this->region->import($io);
            $this->season->import($io);
            $this->time->import($io);
            $this->track->import($io);
            $this->race->import($io);
            $result = true;

            // Conclusion
            $io->info('Import RACE terminé');
        } elseif ($choice === 'export') {
            $this->track->export($io);
            $this->time->export($io);
            $this->season->export($io);
            $this->region->export($io);
            $this->mode->export($io);
            $this->race->export($io);
            $result = true;

            // Conclusion
            $io->info('Les fichiers ont été créés');
        } else {
            $result = false;
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
