<?php

namespace App\Command\Extractor;

use App\Service\Command\Extractor\Race\AppService;
use App\Service\Command\Extractor\Race\ModeService;
use App\Service\Command\Extractor\Race\RegionService;
use App\Service\Command\Extractor\Race\SeasonService;
use App\Service\Command\Extractor\Race\TimeService;
use App\Service\Command\Extractor\Race\TrackService;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:extractor:race',
    description: 'Race Extractor',
    aliases: ['asphalt-extractor-race'],
    hidden: false,
)]
class RaceCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Extractor :::::';

    protected static string $help  = 'Race Extractor';

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly AppService      $race,
        private readonly ModeService     $mode,
        private readonly RegionService   $region,
        private readonly SeasonService   $season,
        private readonly TimeService     $time,
        private readonly TrackService    $track,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io = new SymfonyStyle($input, $output);
        $sw = $this->stopwatch;

        // Start
//        $io->writeln(shell_exec('clear'));

        // Execution time : start
        $sw->start(self::$title);

        // Make directory
        $folder = $this->race->makeDirectory();

        // Get Datas from Database
        $race        = $this->race->extractDatas();
        $raceArray   = json_decode($race, true);
        $mode        = $this->mode->extractDatas();
        $modeArray   = json_decode($mode, true);
        $region      = $this->region->extractDatas();
        $regionArray = json_decode($region, true);
        $season      = $this->season->extractDatas();
        $seasonArray = json_decode($season, true);
        $time        = $this->time->extractDatas();
        $timeArray   = json_decode($time, true);
        $track       = $this->track->extractDatas();
        $trackArray  = json_decode($track, true);

        // Generate File
        $this->race->makeFile($folder, $raceArray);
        $this->mode->makeFile($folder, $modeArray);
        $this->region->makeFile($folder, $regionArray);
        $this->season->makeFile($folder, $seasonArray);
        $this->time->makeFile($folder, $timeArray);
        $this->track->makeFile($folder, $trackArray);

        // Execution time : stop
        $event = $sw->stop(self::$title);

        return Command::SUCCESS;
    }
}
