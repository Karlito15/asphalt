<?php

declare(strict_types=1);

namespace App\Command\YAML\List;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageStatus;
use App\Persistence\Entity\GarageStatusControl;
use App\Persistence\Entity\SettingClass;
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

    protected static string $title   = '::::: Garage List :::::';

    protected static string $help    = 'Créer le listing du Garage';

    private static string $folder     = '';

    private static string $garage     = 'app-garage.yaml';

    private static string $block      = 'filter-block-%s.yaml';

    private static string $gold       = 'filter-gold-%s.yaml';

    private static string $unblock    = 'filter-unblock-%s.yaml';

    private static string $evo        = 'filter-evo-%s.yaml';

    private static string $event      = 'filter-event-class-%s.yaml';

    private static string $toUpgrade  = 'filter-to-upgrade-%s.yaml';

    private static string $orderClass = 'order-by-class-%s.yaml';

    private static string $orderStat  = 'order-by-stat-%s.yaml';

    private static string $toUnblock  = 'to-unblock-%s.yaml';

    private static string $toInstallUpgrade  = 'to-install-upgrade-%s.yaml';

    private static string $toInstallImport  = 'to-install-import-%s.yaml';

    private static string $toGold  = 'to-gold-%s.yaml';

    private static string $fullBlueprint  = 'full-blueprint-%s.yaml';

    private static string $fullEvo  = 'full-evo-%s.yaml';

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

        ### Get Garage

        // Garage List
        $this->garage();

        ### Get Garage Status

        // Get Garage Block
        $this->filter(self::$block, 'unblock', false);
        // Get Garage Gold
        $this->filter(self::$gold, 'gold', true);
        // Get Garage Unblock
        $this->filter(self::$unblock, 'unblock', true);
        // Get Garage Evo
        $this->filter(self::$evo, 'evo', true);
        // Get Garage Event Class
        $this->filter(self::$event, 'eventClass', true);
        // Get Garage To Upgrade
        $this->filter(self::$toUpgrade, 'toUpgrade', true);
        // Get Garage Order by Class
        $this->order(self::$orderClass, ['carOrder' => 'ASC']);
        // Get Garage Order by Stat
        $this->order(self::$orderStat, ['statOrder' => 'ASC']);

        ### Get Garage Status Control

        // Get Garage To Unblock
        $this->toSomething(self::$toUnblock, ['toUnblock' => true]);
        // Get Garage To Install Upgrade
        $this->toSomething(self::$toInstallUpgrade, ['fullUpgrade' => false, 'toInstallUpgrade' => true]);
        // Get Garage To Install Import
        $this->toSomething(self::$toInstallImport, ['fullImport' => false, 'toInstallImport' => true]);
        // Get Garage To Gold
        $this->toSomething(self::$toGold, ['fullUpgrade' => true, 'fullImport' => true, 'toGold' => true]);
        // Get Garage Full Blueprint
        $this->toSomething(self::$fullBlueprint, ['fullBlueprint' => true]);
        // Get Garage Full Evo
        $this->toSomething(self::$fullEvo, ['fullEvo' => true]);

        // Execution time : stop
        $event    = $stopwatch->stop(self::$title);
        $duration = $event->getDuration() / 1000;

        // Resume
        self::resume($io, $duration);
        $logger->info(self::$help);

        return Command::SUCCESS;
    }

    /** PRIVATE METHODS */

    private function garage(): void
    {
        // Get Garage
        $garages = $this->entityManager->getRepository(GarageApp::class)->findBy([], ['gameUpdate' => 'DESC']);

        // Generate File
        try {
            $index = $this->serializer->serialize($garages, 'json', [
                'groups' => ['index'],
                AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
            ]);
            $car = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
            YAML::ArrayToFile(self::$folder . self::$garage, $car);
            $this->io->write('Fichier créé : ' . self::$folder . self::$garage, true);
        } catch (ExceptionInterface$e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function order(string $filename, array $order): void
    {
        foreach (['S', 'A', 'B', 'C', 'D'] as $letter) {
            $class   = $this->getClass($letter);
            $garages = $this->entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class], $order);

            // Generate File
            try {
                $index = $this->serializer->serialize($garages, 'json', [
                    'groups' => ['index'],
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => false,
                ]);
                $file = sprintf($filename, $letter);
                $car  = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
                YAML::ArrayToFile(self::$folder . $file, $car);
                $this->io->write('Fichier créé : ' . self::$folder . $file, true);
            } catch (ExceptionInterface$e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    private function filter(string $filename, string $column, bool $choice): void
    {
        foreach (['S', 'A', 'B', 'C', 'D'] as $letter) {
            $class   = $this->getClass($letter);
            $garages = $this->entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $datas   = $this->entityManager->getRepository(GarageStatus::class)->findBy([$column => $choice, 'garage' => $garages]);

            // Generate File
            try {
                $index = $this->serializer->serialize($datas, 'json', [
                    'groups' => ['filter'],
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                ]);
                $file = sprintf($filename, $letter);
                $car  = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
                YAML::ArrayToFile(self::$folder . $file, $car);
                $this->io->write('Fichier créé : ' . self::$folder . $file, true);

            } catch (ExceptionInterface $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    private function toSomething(string $filename, array $condition): void
    {
        foreach (['S', 'A', 'B', 'C', 'D'] as $letter) {
            $class   = $this->getClass($letter);
            $garages = $this->entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $class]);
            $findBy  = array_merge($condition, ['garage' => $garages]);
            $datas   = $this->entityManager->getRepository(GarageStatusControl::class)->findBy($findBy);

            // Generate File
            try {
                $index = $this->serializer->serialize($datas, 'json', [
                    'groups' => ['filter'],
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                ]);
                $file = sprintf($filename, $letter);
                $car  = json_decode($index, true, 512, JSON_THROW_ON_ERROR);
                YAML::ArrayToFile(self::$folder . $file, $car);
                $this->io->write('Fichier créé : ' . self::$folder . $file, true);

            } catch (ExceptionInterface $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * @param string $class
     * @return SettingClass
     */
    private function getClass(string $class): SettingClass
    {
        return $this->entityManager->getRepository(SettingClass::class)->findByClass($class);
    }
}
