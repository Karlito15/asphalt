<?php

declare(strict_types=1);

namespace App\Command\CSV;

use App\Service\Command\CSV\Setting\BlueprintService;
use App\Service\Command\CSV\Setting\BrandService;
use App\Service\Command\CSV\Setting\ClassService;
use App\Service\Command\CSV\Setting\LevelService;
use App\Service\Command\CSV\Setting\TagService;
use App\Service\Command\CSV\Setting\UnitPriceService;
use App\Service\Command\PathService;
use App\Toolbox\Trait\Command\AllCommand;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'asphalt:csv:setting',
    description: 'Toutes les données pour les Settings',
    aliases: ['asphalt-csv-setting'],
    hidden: false,
)]
class SettingsCommand extends Command
{
    use AllCommand, MigrationCommand;

    protected static string $title = '::::: Settings Datas :::::';

    protected static string $help  = 'Toutes les données pour les Settings';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly BlueprintService       $blueprint,
        private readonly BrandService           $brand,
        private readonly ClassService           $class,
        private readonly LevelService           $level,
        private readonly TagService             $tag,
        private readonly UnitPriceService       $unitPrice,
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Export or Import ?');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get('folders.csv.database');

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        // Get Directory
        $folder     = PathService::getLastDirectory($database);

        // Services Datas
        if ($choice === 'import') {
            $this->blueprint->import($io, $folder);
            $this->brand->import($io, $folder);
            $this->class->import($io, $folder);
            $this->level->import($io, $folder);
            $this->tag->import($io, $folder);
            $this->unitPrice->import($io, $folder);
            $io->info('Import SETTING terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->unitPrice->export($io, $database);
            $this->tag->export($io, $database);
            $this->level->export($io, $database);
            $this->class->export($io, $database);
            $this->brand->export($io, $database);
            $this->blueprint->export($io, $database);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
