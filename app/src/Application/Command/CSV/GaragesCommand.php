<?php

declare(strict_types=1);

namespace App\Application\Command\CSV;

use App\Application\Service\Command\{AllCommand, QuestionCommand};
use App\Application\Service\CSV\Garage\AppCSV;
use App\Application\Service\CSV\Garage\GarageBlueprintCSV;
use App\Application\Service\CSV\Garage\GarageGauntletCSV;
use App\Application\Service\CSV\Garage\GarageRankCSV;
use App\Application\Service\CSV\Garage\GarageStatActualCSV;
use App\Application\Service\CSV\Garage\GarageStatMaxCSV;
use App\Application\Service\CSV\Garage\GarageStatMinCSV;
use App\Application\Service\CSV\Garage\GarageStatusControlCSV;
use App\Application\Service\CSV\Garage\GarageStatusCSV;
use App\Application\Service\CSV\Garage\GarageUpgradeCSV;
use App\Application\Service\CSV\Garage\SettingBlueprintCSV;
use App\Application\Service\CSV\Garage\SettingClassCSV;
use App\Application\Service\CSV\Garage\SettingLevelCSV;
use App\Application\Service\CSV\Garage\SettingUnitPriceCSV;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[AsCommand(
    name: 'asphalt:csv:garage',
    description: 'Toutes les données pour le Garage',
    aliases: ['asphalt-csv-garage'],
    hidden: false,
)]
class GaragesCommand extends Command
{
    use AllCommand, QuestionCommand;

    protected static string $title = '::::: Garages Datas :::::';

    protected static string $help  = '';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly AppCSV                 $garage,
        private readonly GarageBlueprintCSV     $blueprint,
        private readonly GarageGauntletCSV      $gauntlet,
        private readonly GarageRankCSV          $rank,
        private readonly GarageStatActualCSV    $statActual,
        private readonly GarageStatMaxCSV       $statMax,
        private readonly GarageStatMinCSV       $statMin,
        private readonly GarageStatusCSV        $status,
        private readonly GarageStatusControlCSV $statusControl,
        private readonly GarageUpgradeCSV       $upgrade,
        private readonly SettingBlueprintCSV    $settingBlueprint,
        private readonly SettingClassCSV        $settingClass,
        private readonly SettingLevelCSV        $settingLevel,
        private readonly SettingUnitPriceCSV    $settingUnitPrice,
    )
    {
        parent::__construct();
    }

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
        ### Init variables
        $io       = new SymfonyStyle($input, $output);
        $choice   = $input->getArgument('choice');
        $database = $this->parameter->get('csv.folders.database');
        $logger   = $this->logger;
        $result   = false;

        ### Find Last Directory
        $folder   = Folder::getLastDirectory($database);

        ### Question
        $choice   = self::Question(choice: $choice, input: $input, output: $output);

        ### Services Datas
        if ($choice === 'import') {
            $io->write('Garage', true);
            $this->garage->import($io, $folder);
            $io->write('SettingClass', true);
            $this->settingClass->import($io, $folder);
            $io->write('SettingBlueprint', true);
            $this->settingBlueprint->import($io, $folder);
            $io->write('SettingLevel', true);
            $this->settingLevel->import($io, $folder);
            // ToDo : Tags
            $io->write('SettingUnitPrice', true);
            $this->settingUnitPrice->import($io, $folder);
            $io->write('Blueprint', true);
            $this->blueprint->import($io, $folder);
            $io->write('Gauntlet', true);
            $this->gauntlet->import($io, $folder);
            $io->write('Rank', true);
            $this->rank->import($io, $folder);
            $io->write('StatActual', true);
            $this->statActual->import($io, $folder);
            $io->write('StatMax', true);
            $this->statMax->import($io, $folder);
            $io->write('StatMin', true);
            $this->statMin->import($io, $folder);
            $io->write('Status', true);
            $this->status->import($io, $folder);
            $io->write('StatusControl', true);
            $this->statusControl->import($io, $folder);
            $io->write('Upgrade', true);
            $this->upgrade->import($io, $folder);
            $io->success("Les données pour le Garage sont importées");
            $result = true;
        } elseif ($choice === 'export') {
            $this->settingUnitPrice->export($io, $database);
            // ToDo : Tags
            $this->settingLevel->export($io, $database);
            $this->settingClass->export($io, $database);
            $this->settingBlueprint->export($io, $database);
            $this->upgrade->export($io, $database);
            $this->statusControl->export($io, $database);
            $this->status->export($io, $database);
            $this->statMin->export($io, $database);
            $this->statMax->export($io, $database);
            $this->statActual->export($io, $database);
            $this->rank->export($io, $database);
            $this->gauntlet->export($io, $database);
            $this->blueprint->export($io, $database);
            $this->garage->export($io, $database);
            $io->success("Les données pour le Garage sont exportées");
            $result = true;
        } else {
            $logger->error('Fail to Import Inventory');
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
