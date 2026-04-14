<?php

declare(strict_types=1);

namespace App\Application\Command\CSV;

use App\Application\Service\Command\{AllCommand, QuestionCommand};
use App\Application\Service\CSV\Mission\{AppCSV, TaskCSV, TypeCSV};
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
    name: 'asphalt:csv:mission',
    description: 'Toutes les données pour les Missions',
    aliases: ['asphalt-csv-mission'],
    hidden: false,
)]
class MissionsCommand extends Command
{
    use AllCommand, QuestionCommand;

    protected static string $title = '::::: Missions Datas :::::';

    protected static string $help  = '';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly AppCSV                 $mission,
        private readonly TaskCSV                $task,
        private readonly TypeCSV                $type,
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
            $io->write('Task', true);
            $this->task->import($io, $folder);
            $io->write('Type', true);
            $this->type->import($io, $folder);
            $io->write('Mission', true);
            $this->mission->import($io, $folder);
            $io->success("Les données pour les Missions sont importées");
            $result = true;
        } elseif ($choice === 'export') {
            $this->type->export($io, $database);
            $this->task->export($io, $database);
            $this->mission->export($io, $database);
            $io->success("Les données pour les Missions sont exportées");
            $result = true;
        } else {
            $logger->error('Fail to Import Inventory');
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
