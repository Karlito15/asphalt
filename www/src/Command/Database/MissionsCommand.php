<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Service\Database\Mission\AppService;
use App\Service\Database\Mission\TaskService;
use App\Service\Database\Mission\TypeService;
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
    name: 'asphalt:database:mission',
    description: 'Toutes les données pour les Missions',
    aliases: ['asphalt-database-mission'],
    hidden: false,
)]
class MissionsCommand extends Command
{
    use ConfigureAble;
    use InitializeAble;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
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
            $this->type->import($io);
            $this->task->import($io);
            $this->mission->import($io);
            $io->info('Import MISSION terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->type->export($io);
            $this->task->export($io);
            $this->mission->export($io);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
