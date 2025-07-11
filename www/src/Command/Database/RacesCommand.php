<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Service\Database\Race\AppService;
use App\Service\Database\Race\ModeService;
use App\Service\Database\Race\RegionService;
use App\Service\Database\Race\SeasonService;
use App\Service\Database\Race\TimeService;
use App\Service\Database\Race\TrackService;
use Doctrine\ORM\EntityManagerInterface;
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
    aliases: ['asphalt-database-race'],
    hidden: false,
)]
class RacesCommand extends Command
{
    use ConfigureAble;
    use InitializeAble;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly ModeService            $mode,
        private readonly RegionService          $region,
        private readonly SeasonService          $season,
        private readonly TimeService            $time,
        private readonly TrackService           $track,
        private readonly AppService             $race,
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();
        $this->addArgument(
            'choice',
            InputArgument::OPTIONAL,
            'Choose Export or Import'
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** Init variables */
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        /** Start */
        $io->section((string) self::getDefaultDescription());

        /** Question */
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        /** Services Datas */
        if ($choice === 'import') {
            $this->mode->import($io);
            $this->region->import($io);
            $this->season->import($io);
            $this->time->import($io);
            $this->track->import($io);
            $this->race->import($io);
            $io->info('Import RACE terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->track->export($io);
            $this->time->export($io);
            $this->season->export($io);
            $this->region->export($io);
            $this->mode->export($io);
            $this->race->export($io);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
