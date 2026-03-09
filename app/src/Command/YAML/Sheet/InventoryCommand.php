<?php

namespace App\Command\YAML\Sheet;

use App\Persistence\Entity\InventoryApp;
use App\Service\Command\PathService;
use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'asphalt:yaml:sheet:inventory',
    description: 'Créer les fiches pour l\'inventaire',
    aliases: ['asphalt-yaml-inventory'],
    hidden: false,
)]
class InventoryCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Inventory Sheets :::::';

    protected static string $help  = 'Créer les fiches pour l\'inventaire';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SerializerInterface    $serializer,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io        = new SymfonyStyle($input, $output);
        $database  = $this->parameter->get('folders.yaml.sheet');
        $stopwatch = $this->stopwatch;
        $logger    = $this->logger;
        $ext       = '.yaml';

        // Execution time : start
        $stopwatch->start(self::$title);

        // Make Directory
        $io->block('Make Directory');
        $folder    = PathService::makeDirectory($database, 'inventory');

        // Get Datas
        $io->block('Get Datas');
        $coins   = $this->entityManager->getRepository(InventoryApp::class)->sheet('money');
        $commons = $this->entityManager->getRepository(InventoryApp::class)->sheet('common');
        $rares   = $this->entityManager->getRepository(InventoryApp::class)->sheet('rare');
        $jokers  = $this->entityManager->getRepository(InventoryApp::class)->sheet('joker');

        // Generate File
        $io->block('Generate File');
        YAML::ArrayToFile($folder . 'coins' . $ext, $coins);
        YAML::ArrayToFile($folder . 'commons' . $ext, $commons);
        YAML::ArrayToFile($folder . 'rares' . $ext, $rares);
        YAML::ArrayToFile($folder . 'jokers' . $ext, $jokers);

        // Execution time : stop
        $event    = $stopwatch->stop(self::$title);
        $duration = $event->getDuration() / 1000;

        // Resume
        self::resume($io, $duration);
        $logger->info(self::$help);

        return Command::SUCCESS;
    }
}
