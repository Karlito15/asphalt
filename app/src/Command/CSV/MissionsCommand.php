<?php

declare(strict_types=1);

namespace App\Command\CSV;

use App\Service\Command\CSV\Mission\AppService;
use App\Service\Command\CSV\Mission\TaskService;
use App\Service\Command\CSV\Mission\TypeService;
use App\Service\Command\PathService;
use App\Toolbox\Trait\Command\AllCommand;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
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
    name: 'asphalt:csv:mission',
    description: 'Toutes les données pour les Missions',
    aliases: ['asphalt-csv-mission'],
    hidden: false,
)]
class MissionsCommand extends Command
{
    use AllCommand, MigrationCommand;

    protected static string $title = '::::: Missions Datas :::::';

    protected static string $help  = 'Toutes les données pour les Missions';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly AppService             $mission,
        private readonly TaskService            $task,
        private readonly TypeService            $type,
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
        // Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get('folders.csv.database');

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
            $this->task->import($io, $folder);
            $this->type->import($io, $folder);
            $this->mission->import($io, $folder);
            $io->info('Import MISSION terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->type->export($io, $database);
            $this->task->export($io, $database);
            $this->mission->export($io, $database);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
