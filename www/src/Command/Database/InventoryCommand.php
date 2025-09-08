<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use App\Service\CSVs\App\InventoryService;
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
    name: 'asphalt:database:inventory',
    description: 'Toutes les données pour l\'inventaire',
    aliases: ['a:d:i', 'asphalt-database-inventory'],
    hidden: false,
)]
class InventoryCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly InventoryService       $inventory,
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
     * @throws UnavailableStream
     * @throws CannotInsertRecord
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
            $this->inventory->import($io);
            $result = true;

            // Conclusion
            $io->info('Import INVENTORY terminé');
        } elseif ($choice === 'export') {
            $this->inventory->export($io);
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
