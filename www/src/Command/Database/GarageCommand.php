<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use App\Service\CSVs\App\GarageService;
use App\Service\CSVs\Garage\BlueprintService;
use App\Service\CSVs\Garage\BooleanService;
use App\Service\CSVs\Garage\GarageBlueprintService;
use App\Service\CSVs\Garage\GarageLevelService;
use App\Service\CSVs\Garage\GarageUnitPriceService;
use App\Service\CSVs\Garage\RankService;
use App\Service\CSVs\Garage\StatMaxService;
use App\Service\CSVs\Garage\StatMinService;
use App\Service\CSVs\Garage\UpgradeService;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:database:garage',
    description: 'Toutes les données pour le Garage',
    aliases: ['a:d:g', 'asphalt-database-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly GarageService          $garage,
        private readonly GarageBlueprintService $garageBlueprint,
        private readonly GarageLevelService     $garageLevel,
        private readonly GarageUnitPriceService $garageUnitPrice,
        private readonly BlueprintService       $blueprint,
        private readonly BooleanService         $boolean,
        private readonly RankService            $rank,
        private readonly StatMaxService         $statMax,
        private readonly StatMinService         $statMin,
        private readonly UpgradeService         $upgrade,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
       // configure an argument
        $this->addArgument(
            'choice',
            InputArgument::OPTIONAL,
            'Export or Import Settings'
        );
    }

    /**
     * @throws Exception
     * @throws CannotInsertRecord
     * @throws UnavailableStream
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->section((string) self::getDefaultDescription());

        // Introduction
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        // Services
        if ($choice == 'import') {
            $this->garage->import($io);
            $this->garageBlueprint->import($io);
            $this->garageLevel->import($io);
            $this->garageUnitPrice->import($io);
            $this->blueprint->import($io);
            $this->boolean->import($io);
            $this->rank->import($io);
            $this->statMax->import($io);
            $this->statMin->import($io);
            $this->upgrade->import($io);
            $result = true;

            // Conclusion
            $io->info('Import GARAGE terminé');
        } elseif ($choice === 'export') {
            $this->garage->export($io);
            $this->garageBlueprint->export($io);
            $this->garageLevel->export($io);
            $this->garageUnitPrice->export($io);
            $this->blueprint->export($io);
            $this->boolean->export($io);
            $this->rank->export($io);
            $this->statMax->export($io);
            $this->statMin->export($io);
            $this->upgrade->export($io);
            $result = true;

            // Conclusion
            $io->info('Les fichiers ont été créés');
        } else {
            $result = false;
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;

    }
}
