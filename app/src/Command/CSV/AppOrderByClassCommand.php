<?php

declare(strict_types=1);

namespace App\Command\CSV;

use App\Service\Command\CSV\Garage\OrderByClassService;
use App\Toolbox\Trait\Command\AllCommand;
use App\Toolbox\Trait\Command\MigrationCommand;
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
    name: 'asphalt:csv:order:class',
    description: "Exporte les voitures dans l'ordre par Class",
    aliases: ['asphalt-csv-order-class'],
    hidden: false,
)]
class AppOrderByClassCommand extends Command
{
    use AllCommand, MigrationCommand;

    protected static string $title = '::::: Order by Class Datas :::::';

    protected static string $help  = "Exporte les voitures dans l'ordre par Class";

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly OrderByClassService    $service,
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
     * @throws \JsonException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $directory  = $this->parameter->get('folders.csv.order');
        $header     = $this->parameter->get('csv.header.order.class');

        ### Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        ### Services Datas
        if ($choice === 'import') {
            $this->service->import();
            $io->info('Import terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->service->export();
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
