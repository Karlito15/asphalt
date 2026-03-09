<?php

namespace App\Command\YAML\List;

use App\Persistence\Entity\GarageApp;
use App\Service\Command\PathService;
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
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'asphalt:yaml:list:status',
    description: 'Créer les fiches pour les Stats',
    aliases: ['asphalt-yaml-list-status'],
    hidden: false,
)]
class StatusCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Status Sheets :::::';

    protected static string $help  = 'Créer les fiches pour les Stats';

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
        $database  = $this->parameter->get('folders.yaml');
        $stopwatch = $this->stopwatch;
        $logger    = $this->logger;

        // Execution time : start
        $stopwatch->start(self::$title);
        $io->newLine(2);

        // Make Directory
        $folder = PathService::makeDirectory($database, 'list');

        // Get Datas
        $garages   = $this->entityManager->getRepository(GarageApp::class)->findAll();

        // Generate Files
        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['unblock'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'unblock.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['gold'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'gold.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['to-upgrade'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'to-upgrade.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['order-by-class'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'order-by-class.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['order-by-stat'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'order-by-stat.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        try {
            $index = $this->serializer->serialize($garages, 'yaml', [
                'groups' => ['order-by-class-limit-5'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'order-by-class-limit-5.yaml';
            file_put_contents($filepath, $index);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        // Execution time : stop
        $event    = $stopwatch->stop(self::$title);
        $duration = $event->getDuration() / 1000;

        // Resume
        self::resume($io, $duration);
        $logger->info(self::$help);

        return Command::SUCCESS;
    }
}
