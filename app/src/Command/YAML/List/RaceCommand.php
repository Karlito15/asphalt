<?php

declare(strict_types=1);

namespace App\Command\YAML\List;

use App\Persistence\Entity\RaceApp;
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
    name: 'asphalt:yaml:list:race',
    description: 'Créer le listing des Courses',
    aliases: ['asphalt-yaml-list-race'],
    hidden: false,
)]
class RaceCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Race List :::::';

    protected static string $help  = 'Créer le listing des Courses';

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
        $folder = PathService::makeDirectory($database, 'list');

        // Get Datas
        $races  = $this->entityManager->getRepository(RaceApp::class)->findAll();

        // Generate File
        try {
            $index = $this->serializer->serialize($races, 'yaml', [
                'groups' => ['index'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $filepath = $folder . 'race.yaml';
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
