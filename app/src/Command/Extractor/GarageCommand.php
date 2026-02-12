<?php

namespace App\Command\Extractor;

use App\Service\Command\Extractor\Garage\AppService;
use App\Service\Command\Extractor\Garage\GarageStatusService;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:extractor:garage',
    description: 'Garage Extractor',
    aliases: ['asphalt-extractor-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Extractor :::::';

    protected static string $help  = 'Garage Extractor';

    public function __construct(
        private readonly LoggerInterface     $logger,
        private readonly AppService          $garage,
        private readonly GarageStatusService $status,
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
        $folder = $this->garage->makeDirectory();

        // Get Datas from Database
        $garage      = $this->garage->extractDatas();
        $garageArray = json_decode($garage, true);
        $status      = $this->status->extractDatas();
        $statusArray = json_decode($status, true);

        // Generate File
        $this->garage->makeFile($folder, $garageArray);
        $this->status->makeFile($folder, $statusArray);

        // Execution time : stop
        $event = $sw->stop(self::$title);

        return Command::SUCCESS;
    }
}
