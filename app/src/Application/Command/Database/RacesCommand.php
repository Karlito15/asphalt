<?php

declare(strict_types=1);

namespace App\Application\Command\Database;

use App\Application\Service\Command\Database\Race\AppService;
use App\Application\Service\Command\Database\Race\ModeService;
use App\Application\Service\Command\Database\Race\RegionService;
use App\Application\Service\Command\Database\Race\SeasonService;
use App\Application\Service\Command\Database\Race\TimeService;
use App\Application\Service\Command\Database\Race\TrackService;
use App\Application\Service\Command\PathService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'asphalt:database:race',
    description: 'Toutes les données pour les Courses',
    aliases: ['asphalt-database-race'],
    hidden: false,
)]
class RacesCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Races Datas :::::';

    protected static string $help  = 'Toutes les données pour les Courses';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
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
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Choose Export or Import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get('folders.database');

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        // Get Directory
        $folder     = PathService::getLastDirectory($database);

        // Services Datas
        if ($choice === 'import') {
            $this->mode->import($io, $folder);
            $this->region->import($io, $folder);
            $this->season->import($io, $folder);
            $this->time->import($io, $folder);
            $this->track->import($io, $folder);
            $this->race->import($io, $folder);
            $io->info('Import RACE terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->track->export($io, $database);
            $this->time->export($io, $database);
            $this->season->export($io, $database);
            $this->region->export($io, $database);
            $this->mode->export($io, $database);
            $this->race->export($io, $database);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
