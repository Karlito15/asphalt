<?php

namespace App\Command\YAML\Sheet;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageUpgrade;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Entity\SettingLevel;
use App\Service\Command\PathService;
use App\Toolbox\File\YAML;
use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'asphalt:yaml:sheet:stat',
    description: 'Créer les fiches imports pour les statistiques',
    aliases: ['asphalt-yaml-stat'],
    hidden: false,
)]
class StatCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Import Sheets :::::';

    protected static string $help  = 'Créer les fiches imports pour les statistiques';

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
        $io            = new SymfonyStyle($input, $output);
        $database      = $this->parameter->get('folders.yaml.sheet');
        $stopwatch     = $this->stopwatch;
        $logger        = $this->logger;
        $ext           = '.yaml';
        $commonsGarage = $commonsGarageClassD = $commonsGarageClassC = $commonsGarageClassB = $commonsGarageClassA = $commonsGarageClassS =
        $raresGarage   = $raresGarageClassD   = $raresGarageClassC   = $raresGarageClassB   = $raresGarageClassA   = $raresGarageClassS   =
        $epicsGarage   = $epicsGarageClassD   = $epicsGarageClassC   = $epicsGarageClassB   = $epicsGarageClassA   = $epicsGarageClassS   =
        $commonsTotal  = $commonsTotalClassD  = $commonsTotalClassC  = $commonsTotalClassB  = $commonsTotalClassA  = $commonsTotalClassS  =
        $raresTotal    = $raresTotalClassD    = $raresTotalClassC    = $raresTotalClassB    = $raresTotalClassA    = $raresTotalClassS    =
        $epicsTotal    = $epicsTotalClassD    = $epicsTotalClassC    = $epicsTotalClassB    = $epicsTotalClassA    = $epicsTotalClassS    = 0;

        // Execution time : start
        $stopwatch->start(self::$title);

        // Make Directory
        $io->block('Make Directory');
        $folder    = PathService::makeDirectory($database, 'inventory');

        // Get Datas
        $io->block('Get Datas');
        $garages = $this->entityManager->getRepository(GarageApp::class)->findAll();
        foreach ($garages as $garage)
        {
            /** @var SettingClass $class */
            $class        = $garage->getSettingClass();
            $letter       = $class->getValue();
            /** @var SettingLevel $level */
            $level        = $garage->getSettingLevel();
            $commonsTotal += $level->getCommon();
            $raresTotal   += $level->getRare();
            $epicsTotal   += $level->getEpic();
            switch ($letter):
                case 'D':
                    $commonsTotalClassD += $level->getCommon();
                    $raresTotalClassD += $level->getRare();
                    $epicsTotalClassD += $level->getEpic();
                    break;
                case 'C':
                    $commonsTotalClassC += $level->getCommon();
                    $raresTotalClassC += $level->getRare();
                    $epicsTotalClassC += $level->getEpic();
                    break;
                case 'B':
                    $commonsTotalClassB += $level->getCommon();
                    $raresTotalClassB += $level->getRare();
                    $epicsTotalClassB += $level->getEpic();
                    break;
                case 'A':
                    $commonsTotalClassA += $level->getCommon();
                    $raresTotalClassA += $level->getRare();
                    $epicsTotalClassA += $level->getEpic();
                    break;
                case 'S':
                    $commonsTotalClassS += $level->getCommon();
                    $raresTotalClassS += $level->getRare();
                    $epicsTotalClassS += $level->getEpic();
                    break;
            endswitch;
            /** @var GarageUpgrade $upgrade */
            $upgrade       = $garage->getUpgrade();
            $commonsGarage += $upgrade->getCommon();
            $raresGarage   += $upgrade->getRare();
            $epicsGarage   += $upgrade->getEpic();
            switch ($letter):
                case 'D':
                    $commonsGarageClassD += $upgrade->getCommon();
                    $raresGarageClassD += $upgrade->getRare();
                    $epicsGarageClassD += $upgrade->getEpic();
                    break;
                case 'C':
                    $commonsGarageClassC += $upgrade->getCommon();
                    $raresGarageClassC += $upgrade->getRare();
                    $epicsGarageClassC += $upgrade->getEpic();
                    break;
                case 'B':
                    $commonsGarageClassB += $upgrade->getCommon();
                    $raresGarageClassB += $upgrade->getRare();
                    $epicsGarageClassB += $upgrade->getEpic();
                    break;
                case 'A':
                    $commonsGarageClassA += $upgrade->getCommon();
                    $raresGarageClassA += $upgrade->getRare();
                    $epicsGarageClassA += $upgrade->getEpic();
                    break;
                case 'S':
                    $commonsGarageClassS += $upgrade->getCommon();
                    $raresGarageClassS += $upgrade->getRare();
                    $epicsGarageClassS += $upgrade->getEpic();
                    break;
            endswitch;
        }

        // Generate File
        $io->block('Generate File');
        $stats = [
            'Commons' => [
                ['Total' => $commonsTotal, 'Class D' => $commonsTotalClassD, 'Class C' => $commonsTotalClassC, 'Class B' => $commonsTotalClassB, 'Class A' => $commonsTotalClassA, 'Class S' => $commonsTotalClassS],
                ['Garage' => $commonsGarage, 'Class D' => $commonsGarageClassD, 'Class C' => $commonsGarageClassC, 'Class B' => $commonsGarageClassB, 'Class A' => $commonsGarageClassA, 'Class S' => $commonsGarageClassS],
                ['Deficit' => ($commonsTotal - $commonsGarage), 'Class D' => ($commonsTotalClassD - $commonsGarageClassD), 'Class C' => ($commonsTotalClassC - $commonsGarageClassC), 'Class B' => ($commonsTotalClassB - $commonsGarageClassB), 'Class A' => ($commonsTotalClassA - $commonsGarageClassA), 'Class S' => ($commonsGarageClassS)],
            ],
            'Rares' => [
                ['Total' => $raresTotal, 'Class D' => $raresTotalClassD, 'Class C' => $raresTotalClassC, 'Class B' => $raresTotalClassB, 'Class A' => $raresTotalClassA, 'Class S' => $raresTotalClassS],
                ['Garage' => $raresGarage, 'Class D' => $raresGarageClassD, 'Class C' => $raresGarageClassC, 'Class B' => $raresGarageClassB, 'Class A' => $raresGarageClassA, 'Class S' => $raresGarageClassS],
                ['Deficit' => ($raresTotal - $raresGarage), 'Class D' => ($raresTotalClassD - $raresGarageClassD), 'Class C' => ($raresTotalClassC - $raresGarageClassC), 'Class B' => ($raresTotalClassB - $raresGarageClassB), 'Class A' => ($raresTotalClassA - $raresGarageClassA), 'Class S' => $raresGarageClassS],
            ],
            'Epics' => [
                ['Total' => $epicsTotal, 'Class D' => $epicsTotalClassD, 'Class C' => $epicsTotalClassC, 'Class B' => $epicsTotalClassB, 'Class A' => $epicsTotalClassA, 'Class S' => $epicsTotalClassS],
                ['Garage' => $epicsGarage, 'Class D' => $epicsGarageClassD, 'Class C' => $epicsGarageClassC, 'Class B' => $epicsGarageClassB, 'Class A' => $epicsGarageClassA, 'Class S' => $epicsGarageClassS],
                ['Deficit' => ($epicsTotal - $epicsGarage), 'Class D' => ($epicsTotalClassD - $epicsGarageClassD), 'Class C' => ($epicsTotalClassC - $epicsGarageClassC), 'Class B' => ($epicsTotalClassB - $epicsGarageClassB), 'Class A' => ($epicsTotalClassA - $epicsGarageClassA), 'Class S' => $epicsGarageClassS],
            ]
        ];
        YAML::ArrayToFile($folder . 'stats-import' . $ext, $stats);

        // Execution time : stop
        $event    = $stopwatch->stop(self::$title);
        $duration = $event->getDuration() / 1000;

        // Table
        $table = new Table($output);
        $table
            ->setHeaders(['Category', '', 'Total', '', 'ClassD', 'ClassC', 'ClassB', 'ClassA', 'ClassS'])
            ->setRows([
                ['Garage Common', '', $commonsGarage, '', $commonsGarageClassD, $commonsGarageClassC, $commonsGarageClassB, $commonsGarageClassA, $commonsGarageClassS],
                ['Garage Rare', '', $raresGarage, '', $raresGarageClassD, $raresGarageClassC, $raresGarageClassB, $raresGarageClassA, $raresGarageClassS],
                ['Garage Epic', '', $epicsGarage, '', $epicsGarageClassD, $epicsGarageClassC, $epicsGarageClassB, $epicsGarageClassA, $epicsGarageClassS],
                new TableSeparator(),
                ['Total Common', '', $commonsTotal, '', $commonsTotalClassD, $commonsTotalClassC, $commonsTotalClassB, $commonsTotalClassA, $commonsTotalClassS],
                ['Total Rare', '', $raresTotal, '', $raresTotalClassD, $raresTotalClassC, $raresTotalClassB, $raresTotalClassA, $raresTotalClassS],
                ['Total Epic', '', $epicsTotal, '', $epicsTotalClassD, $epicsTotalClassC, $epicsTotalClassB, $epicsTotalClassA, $epicsTotalClassS],
                new TableSeparator(),
                ['Deficit Common', '', ($commonsTotal - $commonsGarage), '', ($commonsTotalClassD - $commonsGarageClassD), ($commonsTotalClassC - $commonsGarageClassC), ($commonsTotalClassB - $commonsGarageClassB), ($commonsTotalClassA - $commonsGarageClassA), ($commonsTotalClassS - $commonsGarageClassS)],
                ['Deficit Rare', '', ($raresTotal - $raresGarage), '', ($raresTotalClassD - $raresGarageClassD), ($raresTotalClassC - $raresGarageClassC), ($raresTotalClassB - $raresGarageClassB), ($raresTotalClassA - $raresGarageClassA), ($raresTotalClassS - $raresGarageClassS)],
                ['Deficit Epic', '', ($epicsTotal - $epicsGarage), '', ($epicsTotalClassD - $epicsGarageClassD), ($epicsTotalClassC - $epicsGarageClassC), ($epicsTotalClassB - $epicsGarageClassB), ($epicsTotalClassA - $epicsGarageClassA), ($epicsTotalClassS - $epicsGarageClassS)],
            ])
        ;
        $table->render();

        // Resume
        self::resume($io, $duration);
        $logger->info(self::$help);

        return Command::SUCCESS;
    }
}
