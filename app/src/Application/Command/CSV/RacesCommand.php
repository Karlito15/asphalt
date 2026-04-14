<?php

namespace App\Application\Command\CSV;

use App\Application\Service\Command\{AllCommand, QuestionCommand};
use App\Application\Service\CSV\Race\{AppCSV, ModeCSV, RegionCSV, SeasonCSV, TimeCSV, TrackCSV};
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'asphalt:csv:race',
    description: 'Toutes les données pour les Courses',
    aliases: ['asphalt-csv-race'],
    hidden: false,
)]
class RacesCommand extends Command
{
    use AllCommand, QuestionCommand;

    protected static string $title = '::::: Races Datas :::::';

    protected static string $help  = '';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly ModeCSV                $mode,
        private readonly RegionCSV              $region,
        private readonly SeasonCSV              $season,
        private readonly TimeCSV                $time,
        private readonly TrackCSV               $track,
        private readonly AppCSV                 $race,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Export or Import ?');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get('csv.folders.database');
        $logger     = $this->logger;
        $result     = false;

        ### Find Last Directory
        $folder     = Folder::getLastDirectory($database);

        ### Question
        $choice     = self::Question(choice: $choice, input: $input, output: $output);

        ### Services Datas
        if ($choice === 'import') {
            $io->write('Mode', true);
            $this->mode->import($io, $folder);
            $io->write('Region', true);
            $this->region->import($io, $folder);
            $io->write('Season', true);
            $this->season->import($io, $folder);
            $io->write('Time', true);
            $this->time->import($io, $folder);
            $io->write('Track', true);
            $this->track->import($io, $folder);
            $io->write('Race', true);
            $this->race->import($io, $folder);
            $io->success("Les données pour les Races sont importées");
            $result = true;
        } elseif ($choice === 'export') {
            $this->track->export($io, $database);
            $this->time->export($io, $database);
            $this->season->export($io, $database);
            $this->region->export($io, $database);
            $this->mode->export($io, $database);
            $this->race->export($io, $database);
            $io->success("Les données pour les Races sont exportées");
            $result = true;
        } else {
            $logger->error('Fail to Import Inventory');
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
