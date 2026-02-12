<?php

namespace App\Command\Extractor;

use App\Service\Command\Extractor\Mission\AppService;
use App\Service\Command\Extractor\Mission\TaskService;
use App\Service\Command\Extractor\Mission\TypeService;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:extractor:mission',
    description: 'Mission Extractor',
    aliases: ['asphalt-extractor-mission'],
    hidden: false,
)]
class MissionCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Extractor :::::';

    protected static string $help  = 'Mission Extractor';

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly AppService      $mission,
        private readonly TaskService     $task,
        private readonly TypeService     $type,
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
        $folder = $this->mission->makeDirectory();

        // Get Datas from Database
        $mission      = $this->mission->extractDatas();
        $missionArray = json_decode($mission, true);
        $task          = $this->task->extractDatas();
        $taskArray     = json_decode($task, true);
        $type          = $this->type->extractDatas();
        $typeArray     = json_decode($type, true);

        // Generate File
        $this->mission->makeFile($folder, $missionArray);
        $this->task->makeFile($folder, $taskArray);
        $this->type->makeFile($folder, $typeArray);

        // Execution time : stop
        $event = $sw->stop(self::$title);

        return Command::SUCCESS;
    }
}
