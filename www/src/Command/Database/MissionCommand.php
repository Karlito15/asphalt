<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use App\Service\CSVs\App\MissionService;
use App\Service\CSVs\Mission\TaskService;
use App\Service\CSVs\Mission\TypeService;
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
    name: 'asphalt:database:mission',
    description: 'Toutes les données pour les Missions',
    aliases: ['a:d:m', 'asphalt-database-mission'],
    hidden: false,
)]
class MissionCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly TaskService            $task,
        private readonly TypeService            $type,
        private readonly MissionService         $mission,
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
     * @throws CannotInsertRecord
     * @throws UnavailableStream
     * @throws Exception
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
            $this->task->import($io);
            $this->type->import($io);
            $this->mission->import($io);
            $result = true;

            // Conclusion
            $io->info('Import MISSION terminé');
        } elseif ($choice === 'export') {
            $this->type->export($io);
            $this->task->export($io);
            $this->mission->export($io);
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
