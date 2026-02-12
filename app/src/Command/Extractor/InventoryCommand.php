<?php

namespace App\Command\Extractor;

use App\Service\Command\Extractor\InventoryService;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:extractor:inventory',
    description: 'Inventory Extractor',
    aliases: ['asphalt-extractor-inventory'],
    hidden: false,
)]
class InventoryCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Extractor :::::';

    protected static string $help  = 'Inventory Extractor';

    public function __construct(
        private readonly LoggerInterface  $logger,
        private readonly InventoryService $service,
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
        $folder = $this->service->makeDirectory();

        // Get Datas from Database
        $json = $this->service->extractDatas();
        $array = json_decode($json, true);

        // Generate File
        $this->service->makeFile($folder, $array);

        // Execution time : stop
        $event = $sw->stop(self::$title);

        return Command::SUCCESS;
    }
}
