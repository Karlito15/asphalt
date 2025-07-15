<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Service\Database\InventoryService;
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
    name: 'asphalt:database:inventory',
    description: 'Toutes les données pour l\'Inventaire',
    aliases: ['asphalt-database-inventory'],
    hidden: false,
)]
class InventoriesCommand extends Command
{
    use ConfigureAble;
    use InitializeAble;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly InventoryService       $inventory,
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
        // Init variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->section((string) self::getDefaultDescription());

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        // Services Datas
        if ($choice === 'import') {
            $this->inventory->import($io);
            $io->info('Import INVENTORY terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->inventory->export($io);
            $result = true;
            $io->info('Les fichiers ont été créés');
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
