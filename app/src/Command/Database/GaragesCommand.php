<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Service\Command\Database\Garage\GarageAppService;
use App\Service\Command\Database\Garage\GarageBlueprintService;
use App\Service\Command\Database\Garage\GarageGauntletService;
use App\Service\Command\Database\Garage\GarageRankService;
use App\Service\Command\Database\Garage\GarageStatActualService;
use App\Service\Command\Database\Garage\GarageStatMaxService;
use App\Service\Command\Database\Garage\GarageStatMinService;
use App\Service\Command\Database\Garage\GarageStatusService;
use App\Service\Command\Database\Garage\GarageUpgradeService;
use App\Service\Command\Database\Garage\SettingBlueprintService;
use App\Service\Command\Database\Garage\SettingLevelService;
use App\Service\Command\Database\Garage\SettingUnitPriceService;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
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

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly EntityManagerInterface  $entityManager,
        private readonly GarageAppService        $garage,
        private readonly GarageGauntletService   $gauntlet,
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
        private readonly ParameterBagInterface   $parameter,
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->section($this->getDescription());

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        // Services Datas
        if ($choice === 'import') {
            $this->garage->import($io);
            $this->settingBlueprint->import($io);
            $this->settingLevel->import($io);
            $this->settingUnitPrice->import($io);
            $this->blueprint->import($io);
            $this->gauntlet->import($io);
            $this->rank->import($io);
            $this->statActual->import($io);
            $this->statMax->import($io);
            $this->statMin->import($io);
            $this->status->import($io);
            $this->upgrade->import($io);
            $io->info('Import GARAGE terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->settingUnitPrice->export($io);
            $this->settingLevel->export($io);
            $this->settingBlueprint->export($io);
            $this->upgrade->export($io);
            $this->status->export($io);
            $this->statMin->export($io);
            $this->statMax->export($io);
            $this->statActual->export($io);
            $this->rank->export($io);
            $this->gauntlet->export($io);
            $this->blueprint->export($io);
            $this->garage->export($io);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
