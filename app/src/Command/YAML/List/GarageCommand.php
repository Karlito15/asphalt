<?php

declare(strict_types=1);

namespace App\Command\YAML\List;

use App\Persistence\Entity\GarageApp;
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
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'asphalt:yaml:list:garage',
    description: 'Créer le listing du Garage',
    aliases: ['asphalt-yaml-list-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Garage List :::::';

    protected static string $help  = 'Créer le listing du Garage';

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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io        = new SymfonyStyle($input, $output);
        $database  = $this->parameter->get('folders.yaml');
        $stopwatch = $this->stopwatch;
        $logger = $this->logger;

        // Execution time : start
        $stopwatch->start(self::$title);
        $io->newLine(2);

        // Make Directory
        $folder    = PathService::makeDirectory($database, 'list');

        // Get Datas
        $garages   = $this->entityManager->getRepository(GarageApp::class)->findBy([], ['gameUpdate' => 'DESC']);

        // Generate File
        try {
            $index = $this->serializer->serialize($garages, 'json', [
                'groups' => ['index'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'garage.yaml';
                $car = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
                YAML::ArrayToFile($filepath, $car);
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
