<?php

declare(strict_types=1);

namespace App\Command\YAML\List;

use App\Persistence\Entity\MissionApp;
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
    name: 'asphalt:yaml:list:mission',
    description: 'Créer le listing des Missions',
    aliases: ['asphalt-yaml-list-mission'],
    hidden: false,
)]
class MissionCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Mission List :::::';

    protected static string $help  = 'Créer le listing des Missions';

    private static string $folder  = '';

    private static string $file    = 'app-mission.yaml';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SerializerInterface    $serializer,
    )
    {
        parent::__construct();

        // Make Directory
        $database     = $this->parameter->get('folders.yaml');
        self::$folder = PathService::makeDirectory($database, 'list');
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
        $io        = new SymfonyStyle($input, $output);
        $stopwatch = $this->stopwatch;
        $logger    = $this->logger;

        ### Execution time : start
        $stopwatch->start(self::$title);
        $io->newLine(2);

        ### Get Datas
        $missions  = $this->entityManager->getRepository(MissionApp::class)->findBy([], ['week' => 'ASC']);

        ### Generate File
        try {
            $index = $this->serializer->serialize($missions, 'json', [
                'groups' => ['index'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $datas = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
            YAML::ArrayToFile(self::$folder . self::$file, $datas);
            $this->io->write('Fichier créé : ' . self::$folder . self::$file, true);
        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
        }

        ### Execution time : stop
        $event    = $stopwatch->stop(self::$title);
        $duration = $event->getDuration() / 1000;

        ### Resume
        self::resume($io, $duration);
        $logger->info(self::$help);

        return Command::SUCCESS;
    }
}
