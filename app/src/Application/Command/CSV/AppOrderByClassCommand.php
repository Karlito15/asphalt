<?php

declare(strict_types=1);

namespace App\Application\Command\CSV;

use App\Application\Service\Command\AllCommand;
use App\Application\Service\Command\QuestionCommand;
use App\Application\Service\CSV\OrderByClassCSV;
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
    name: 'asphalt:csv:order:class',
    description: "Exporte les voitures dans l'ordre par Class",
    aliases: ['asphalt-csv-order-class'],
    hidden: false,
)]
class AppOrderByClassCommand extends Command
{
    use AllCommand, QuestionCommand;

    protected static string $title = '::::: Order by Class Datas :::::';

    protected static string $help  = '';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly OrderByClassCSV        $service,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Export or Import ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $directory  = $this->parameter->get('csv.folders.order');
        $header     = $this->parameter->get('csv.header.order.class');
//        $file       = $this->parameter->get('csv.file.order.class');

        ### Question
        $choice     = self::Question(choice: $choice, input: $input, output: $output);

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
