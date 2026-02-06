<?php

declare(strict_types=1);

namespace App\Application\Command\Database;

use App\Application\Service\Command\Database\Garage\GarageAppService;
use App\Application\Service\Command\Database\Garage\GarageBlueprintService;
use App\Application\Service\Command\Database\Garage\GarageEvoService;
use App\Application\Service\Command\Database\Garage\GarageGauntletService;
use App\Application\Service\Command\Database\Garage\GarageRankService;
use App\Application\Service\Command\Database\Garage\GarageStatActualService;
use App\Application\Service\Command\Database\Garage\GarageStatMaxService;
use App\Application\Service\Command\Database\Garage\GarageStatMinService;
use App\Application\Service\Command\Database\Garage\GarageStatusService;
use App\Application\Service\Command\Database\Garage\GarageUpgradeService;
use App\Application\Service\Command\Database\Garage\SettingBlueprintService;
use App\Application\Service\Command\Database\Garage\SettingLevelService;
use App\Application\Service\Command\Database\Garage\SettingUnitPriceService;
use App\Application\Service\Command\PathService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
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
    name: 'asphalt:database:garage',
    description: 'Toutes les données pour le Garage',
    aliases: ['asphalt-database-garage'],
    hidden: false,
)]
class GaragesCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Garages Datas :::::';

    protected static string $help  = 'Toutes les données pour le Garage';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly EntityManagerInterface  $entityManager,
        private readonly LoggerInterface         $logger,
        private readonly ParameterBagInterface   $parameter,
        private readonly GarageAppService        $garage,
        private readonly GarageGauntletService   $gauntlet,
        private readonly GarageEvoService        $evo,
        private readonly GarageBlueprintService  $blueprint,
        private readonly GarageRankService       $rank,
        private readonly GarageStatActualService $statActual,
        private readonly GarageStatMaxService    $statMax,
        private readonly GarageStatMinService    $statMin,
        private readonly GarageStatusService     $status,
        private readonly GarageUpgradeService    $upgrade,
        private readonly SettingBlueprintService $settingBlueprint,
        private readonly SettingLevelService     $settingLevel,
        private readonly SettingUnitPriceService $settingUnitPrice,
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
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Choose Export or Import');
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
        $database   = $this->parameter->get('folders.database');

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
            $this->garage->import($io, $folder);
            $this->settingBlueprint->import($io, $folder);
            $this->settingLevel->import($io, $folder);
            // ToDo : Tags
            $this->settingUnitPrice->import($io, $folder);
            $this->blueprint->import($io, $folder);
            $this->evo->import($io, $folder);
            $this->gauntlet->import($io, $folder);
            $this->rank->import($io, $folder);
            $this->statActual->import($io, $folder);
            $this->statMax->import($io, $folder);
            $this->statMin->import($io, $folder);
            $this->status->import($io, $folder);
            $this->upgrade->import($io, $folder);
            $io->info('Import GARAGE terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->settingUnitPrice->export($io, $database);
            $this->settingLevel->export($io, $database);
            $this->settingBlueprint->export($io, $database);
            $this->upgrade->export($io, $database);
            $this->status->export($io, $database);
            $this->statMin->export($io, $database);
            $this->statMax->export($io, $database);
            $this->statActual->export($io, $database);
            $this->rank->export($io, $database);
            $this->gauntlet->export($io, $database);
            $this->evo->export($io, $database);
            $this->blueprint->export($io, $database);
            $this->garage->export($io, $database);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
