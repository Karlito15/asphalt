<?php

namespace App\Command\Extractor;

use App\Service\Command\Extractor\Setting\BlueprintService;
use App\Service\Command\Extractor\Setting\BrandService;
use App\Service\Command\Extractor\Setting\ClassService;
use App\Service\Command\Extractor\Setting\LevelService;
use App\Service\Command\Extractor\Setting\TagService;
use App\Service\Command\Extractor\Setting\UnitPriceService;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:extractor:setting',
    description: 'Setting Extractor',
    aliases: ['asphalt-extractor-setting'],
    hidden: false,
)]
class SettingCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Extractor :::::';

    protected static string $help  = 'Setting Extractor';

    public function __construct(
        private readonly LoggerInterface  $logger,
        private readonly BlueprintService $blueprint,
        private readonly BrandService     $brand,
        private readonly ClassService     $class,
        private readonly LevelService     $level,
        private readonly TagService       $tag,
        private readonly UnitPriceService $unitPrice,
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
        $folder = $this->blueprint->makeDirectory();

        // Get Datas from Database
        $blueprint      = $this->blueprint->extractDatas();
        $blueprintArray = json_decode($blueprint, true);
        $brand          = $this->brand->extractDatas();
        $brandArray     = json_decode($brand, true);
        $class          = $this->class->extractDatas();
        $classArray     = json_decode($class, true);
        $level          = $this->level->extractDatas();
        $levelArray     = json_decode($level, true);
        $tag            = $this->tag->extractDatas();
        $tagArray       = json_decode($tag, true);
        $unitPrice      = $this->unitPrice->extractDatas();
        $unitPriceArray = json_decode($unitPrice, true);

        // Generate File
        $this->blueprint->makeFile($folder, $blueprintArray);
        $this->brand->makeFile($folder, $brandArray);
        $this->class->makeFile($folder, $classArray);
        $this->level->makeFile($folder, $levelArray);
        $this->tag->makeFile($folder, $tagArray);
        $this->unitPrice->makeFile($folder, $unitPriceArray);

        // Execution time : stop
        $event = $sw->stop(self::$title);

        return Command::SUCCESS;
    }
}
