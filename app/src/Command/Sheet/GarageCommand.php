<?php

namespace App\Command\Sheet;

use App\Entity\GarageApp;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use App\Trait\Command\ResumeTrait;
use App\Trait\Service\File\DirectoryTrait;
use App\Trait\Service\File\YAMLTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'asphalt:sheet:garage',
    description: "Exporte toutes les fiches du garage",
    aliases: ['asphalt-sheet-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use ResumeTrait;
    use DirectoryTrait;
    use YAMLTrait;

    protected static string $title = '::::: Sheets Garage :::::';

    protected static string $folder = 'sheets' . DIRECTORY_SEPARATOR . 'garage' . DIRECTORY_SEPARATOR;

    protected static string $file = 'XXX.yaml';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $manager,
        private readonly ParameterBagInterface  $parameter,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io        = new SymfonyStyle($input, $output);
        $fs        = new Filesystem();
        $stopwatch = $this->stopwatch;
        $garages   = $this->manager->getRepository(GarageApp::class)->findAll();

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());
        $output->writeln(shell_exec('clear'));

        // Execution time : start
        $stopwatch->start(self::$title);

        // Progress Bar : Star
        $this->io->progressStart(count($garages));
        $this->io->newLine();
        foreach ($garages as $garage) {
            // Extract All Datas
            $entity = $this->manager->getRepository(GarageApp::class)->getGarageOne($garage->getId(), $garage->getSlug());
            $datas  = self::extract($entity);

            // Write YAML
            $filepath = $this->getYAMLDir() . self::$folder . self::filename($garage);
            if (false === $fs->exists($this->getYAMLDir() . self::$folder)) {
                $fs->mkdir($this->getYAMLDir() . self::$folder);
            }
            self::writeFile($filepath, $datas);

            // Progress Bar : +1
            $this->io->progressAdvance();
        }

        // Progress Bar : Stop
        $this->io->progressFinish();

        // Execution time : stop
        $event      = $stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        $io->info($this->getYAMLDir() . self::$folder);

        return Command::SUCCESS;
    }

    private static function extract(array $entity): array
    {
        $blueprint_star_1 = ($entity['blueprint_star1'] === 'Key') ? (string) $entity['garage_star1'] : (int) $entity['garage_star1'];
        $setting_star_1   = ($entity['blueprint_star1'] === 'Key') ? (string) $entity['blueprint_star1'] : (int) $entity['blueprint_star1'];

        return [
            // Garage
            'Garage'    => [
                'Car Name'     => $entity['brand'] . " " . $entity['model'],
                'Slug'         => $entity['slug'],
                'Brand'        => $entity['brand'],
                'Model'        => $entity['model'],
                'Class'        => $entity['class_value'],
                'Median Class' => $entity['class_median'],
                'Game Update'  => $entity['gameUpdate'],
                'Stars'        => $entity['stars'],
                'Progression'  => [
                    'Level'      => $entity['level'],
                    'Full Level' => $entity['level_level'],
                    'Epic'       => $entity['epic'],
                    'Full Epic'  => $entity['level_epic'],
                ],
                'Orders'       => [
                    'Car'  => $entity['carOrder'],
                    'Stat' => $entity['statOrder'],
                    'Total Car'  => $entity['class_number'],
                ],
                'Updated At'   => date_format($entity['updatedAt'], 'Y/m/d H:i'),
            ],
            // Blueprints
            'Blueprint' => [
                'Star 1' => [
                    'Garage' => $blueprint_star_1,
                    'Setting' => $setting_star_1,
                    'Difference' => self::difference($blueprint_star_1, $setting_star_1)
                ],
                'Star 2' => [
                    'Garage' => $entity['garage_star2'],
                    'Setting' => $entity['blueprint_star2'],
                    'Difference' => self::difference($entity['garage_star2'], $entity['blueprint_star2'])
                ],
                'Star 3' => [
                    'Garage' => $entity['garage_star3'],
                    'Setting' => $entity['blueprint_star3'],
                    'Difference' => self::difference($entity['garage_star3'], $entity['blueprint_star3'])
                ],
                'Star 4' => [
                    'Garage' => $entity['garage_star4'],
                    'Setting' => $entity['blueprint_star4'],
                    'Difference' => self::difference($entity['garage_star4'], $entity['blueprint_star4'])
                ],
                'Star 5' => [
                    'Garage' => $entity['garage_star5'],
                    'Setting' => $entity['blueprint_star5'],
                    'Difference' => self::difference($entity['garage_star5'], $entity['blueprint_star5'])
                ],
                'Star 6' => [
                    'Garage' => $entity['garage_star6'],
                    'Setting' => $entity['blueprint_star6'],
                    'Difference' => self::difference($entity['garage_star6'], $entity['blueprint_star6'])
                ],
                'Full' => [
                    'Garage' => $entity['garage_total'],
                    'Setting' => $entity['blueprint_total'],
                    'Difference' => self::difference($entity['garage_total'], $entity['blueprint_total'])
                ],
            ],
            // Gauntlet
            'Gauntlet'  => [
                'Division' => (int) $entity['gauntlet_division'],
            ],
            // Ranks
            'Rank'      => [
                'Start'  => (int) $entity['rank_star0'],
                'Star 1' => (int) $entity['rank_star1'],
                'Star 2' => (int) $entity['rank_star2'],
                'Star 3' => (int) $entity['rank_star3'],
                'Star 4' => (int) $entity['rank_star4'],
                'Star 5' => (int) $entity['rank_star5'],
                'Star 6' => (int) $entity['rank_star6'],
            ],
            // Status
            'Status'    => [
                'Unblock'    => [
                    'isUnblock' => $entity['status_unblock'],
                    'toUnblock' => $entity['status_to_unblock'],
                ],
                'Gold'       => [
                    'isGold' => $entity['status_gold'],
                    'toGold' => $entity['status_to_gold'],
                ],
                'To Upgrade' => [
                    'isFull' => $entity['status_full_upgrade_level'],
                    'toUpgrade' => $entity['status_to_upgrade_level'],
                ],
                'Blueprint' => [
                    'Star 1' => $entity['status_full_blueprint_star1'],
                    'Star 2' => $entity['status_full_blueprint_star2'],
                    'Star 3' => $entity['status_full_blueprint_star3'],
                    'Star 4' => $entity['status_full_blueprint_star4'],
                    'Star 5' => $entity['status_full_blueprint_star5'],
                    'Star 6' => $entity['status_full_blueprint_star6'],
                ],
                'Full Upgrade' => [
                    'Speed'        => $entity['status_full_upgrade_speed'],
                    'Acceleration' => $entity['status_full_upgrade_acceleration'],
                    'Handling'     => $entity['status_full_upgrade_handling'],
                    'Nitro'        => $entity['status_full_upgrade_nitro'],
                    'Common'       => $entity['status_full_upgrade_common'],
                    'Rare'         => $entity['status_full_upgrade_rare'],
                    'Epic'         => $entity['status_full_upgrade_epic'],
                ],
                'To Install' => [
                    'Speed'        => $entity['status_to_install_upgrade_speed'],
                    'Acceleration' => $entity['status_to_install_upgrade_acceleration'],
                    'Handling'     => $entity['status_to_install_upgrade_handling'],
                    'Nitro'        => $entity['status_to_install_upgrade_nitro'],
                    'Common'       => $entity['status_to_install_upgrade_common'],
                    'Rare'         => $entity['status_to_install_upgrade_rare'],
                    'Epic'         => $entity['status_to_install_upgrade_epic'],
                ],
            ],
            // Stats
            'Stat' => [
                'Min Speed'           => self::decimal((float) $entity['min_speed']),
                'Actual Speed'        => self::decimal((float) $entity['actual_speed']),
                'Max Speed'           => self::decimal((float) $entity['max_speed']),
                'Min Acceleration'    => self::decimal((float) $entity['min_acceleration']),
                'Actual Acceleration' => self::decimal((float) $entity['actual_acceleration']),
                'Max Acceleration'    => self::decimal((float) $entity['max_acceleration']),
                'Min Handly'          => self::decimal((float) $entity['min_handling']),
                'Actual Handly'       => self::decimal((float) $entity['actual_handling']),
                'Max Handly'          => self::decimal((float) $entity['max_handling']),
                'Min Nitro'           => self::decimal((float) $entity['min_nitro']),
                'Actual Nitro'        => self::decimal((float) $entity['actual_nitro']),
                'Max Nitro'           => self::decimal((float) $entity['max_nitro']),
                'Min Average'         => self::decimal((float) $entity['min_average']),
                'Actual Average'      => self::decimal((float) $entity['actual_average']),
                'Max Average'         => self::decimal((float) $entity['max_average']),
            ],
            // Upgrades
            'Upgrade' => [
                'Speed'        => [
                    'Garage'  => (int) $entity['upgrade_speed'],
                    'Level'   => $entity['level'],
                    'Difference' => self::difference((int) $entity['upgrade_speed'], $entity['level']),
                    'Setting' => $entity['level_level'],
                ],
                'Acceleration' => [
                    'Garage'  => (int) $entity['upgrade_acceleration'],
                    'Level'   => $entity['level'],
                    'Difference' => self::difference((int) $entity['upgrade_acceleration'], $entity['level']),
                    'Setting' => $entity['level_level'],
                ],
                'Handling'     => [
                    'Garage'  => (int) $entity['upgrade_handling'],
                    'Level'   => $entity['level'],
                    'Difference' => self::difference((int) $entity['upgrade_handling'], $entity['level']),
                    'Setting' => $entity['level_level'],
                ],
                'Nitro'        => [
                    'Garage'  => (int) $entity['upgrade_nitro'],
                    'Level'   => $entity['level'],
                    'Difference' => self::difference((int) $entity['upgrade_nitro'], $entity['level']),
                    'Setting' => $entity['level_level'],
                ],
                'Common'       => [
                    'Garage'  => (int) $entity['upgrade_common'],
                    'Setting' => $entity['level_common'],
                    'Difference' => self::difference((int) $entity['upgrade_common'], $entity['level_common']),
                ],
                'Rare'         => [
                    'Garage'  => (int) $entity['upgrade_rare'],
                    'Setting' => $entity['level_rare'],
                    'Difference' => self::difference((int) $entity['upgrade_rare'], $entity['level_rare']),
                ],
                'Epic'         => [
                    'Garage'  => (int) $entity['upgrade_epic'],
                    'Setting' => $entity['level_epic'],
                    'Difference' => self::difference((int) $entity['upgrade_epic'], $entity['epic']),
                ],
            ],
            // Prices
            'Price' => [
                'Unit Price' => [
                    'Level 01' => (int) $entity['unitPrice_level01'],
                    'Level 02' => (int) $entity['unitPrice_level02'],
                    'Level 03' => (int) $entity['unitPrice_level03'],
                    'Level 04' => (int) $entity['unitPrice_level04'],
                    'Level 05' => (int) $entity['unitPrice_level05'],
                    'Level 06' => (int) $entity['unitPrice_level06'],
                    'Level 07' => (int) $entity['unitPrice_level07'],
                    'Level 08' => (int) $entity['unitPrice_level08'],
                    'Level 09' => (int) $entity['unitPrice_level09'],
                    'Level 10' => (int) $entity['unitPrice_level10'],
                    'Level 11' => (int) $entity['unitPrice_level11'],
                    'Level 12' => (int) $entity['unitPrice_level12'],
                    'Level 13' => (int) $entity['unitPrice_level13'],
                    'Level Common' => (int) $entity['unitPrice_common'],
                    'Level Rare' => (int) $entity['unitPrice_rare'],
                    'Level Epic' => (int) $entity['unitPrice_epic'],
                ],
                'Price Real Upgrades' => [
                    'Speed'        => self::priceUpgrades($entity, $entity['upgrade_speed']),
                    'Acceleration' => self::priceUpgrades($entity, $entity['upgrade_acceleration']),
                    'Handling'     => self::priceUpgrades($entity, $entity['upgrade_handling']),
                    'Nitro'        => self::priceUpgrades($entity, $entity['upgrade_nitro']),
                ],
                'Price Total Upgrades' => [
                    'Speed'        => self::priceUpgrades($entity, $entity['level_level']),
                    'Acceleration' => self::priceUpgrades($entity, $entity['level_level']),
                    'Handling'     => self::priceUpgrades($entity, $entity['level_level']),
                    'Nitro'        => self::priceUpgrades($entity, $entity['level_level']),
                ],
                'Price Real Imports' => [
                    'Common' => self::priceImports($entity, 'common', 'real'),
                    'Rare'   => self::priceImports($entity, 'rare', 'real'),
                    'Epic'   => self::priceImports($entity, 'epic', 'real'),
                ],
                'Price Total Imports' => [
                    'Common' => self::priceImports($entity, 'common', 'total'),
                    'Rare'   => self::priceImports($entity, 'rare', 'total'),
                    'Epic'   => self::priceImports($entity, 'epic', 'total'),
                ],
                'Price Gold' =>
                    (self::priceUpgrades($entity, $entity['level_level']) * 4) +
                    self::priceImports($entity, 'common', 'total') +
                    self::priceImports($entity, 'rare', 'total') +
                    self::priceImports($entity, 'epic', 'total'),
            ],
        ];
    }

    /**
     * @param GarageApp $garage
     * @return string
     */
    private static function filename(GarageApp $garage): string
    {
        return str_replace("XXX", $garage->getSlug(), self::$file);
    }

    private static function decimal(float $value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * @param int|string $actual
     * @param int|string $max
     * @return int
     */
    private static function difference(int|string $actual, int|string $max): int
    {
        // Int
        if (is_int($max)) {
            return $max - $actual;
        }

        // String (Key)
        if (is_string($max)) {
            if ($max === $actual) {
                return 0;
            }
            return 1;
        }
    }

    /**
     * @param array $entity
     * @param int $level
     * @return int
     */
    private static function priceUpgrades(array $entity, int $level): int
    {
        $prices = [
            (int) $entity['unitPrice_level01'],
            (int) $entity['unitPrice_level02'],
            (int) $entity['unitPrice_level03'],
            (int) $entity['unitPrice_level04'],
            (int) $entity['unitPrice_level05'],
            (int) $entity['unitPrice_level06'],
            (int) $entity['unitPrice_level07'],
            (int) $entity['unitPrice_level08'],
            (int) $entity['unitPrice_level09'],
            (int) $entity['unitPrice_level10'],
            (int) $entity['unitPrice_level11'],
            (int) $entity['unitPrice_level12'],
            (int) $entity['unitPrice_level13']
        ];

        return array_sum(array_slice($prices, 0, $level));
    }

    private static function priceImports(array $entity, string $import, string $choice): int
    {
        if ($choice === 'real') {
            return match ($import) {
                'common' => ($entity['unitPrice_common'] * $entity['upgrade_common']),
                'rare' => ($entity['unitPrice_rare'] * $entity['upgrade_rare']),
                'epic' => ($entity['unitPrice_epic'] * $entity['upgrade_epic']),
            };
        }

        if ($choice === 'total') {
            return match ($import) {
                'common' => ($entity['unitPrice_common'] * $entity['level_common']),
                'rare' => ($entity['unitPrice_rare'] * $entity['level_rare']),
                'epic' => ($entity['unitPrice_epic'] * $entity['level_epic']),
            };
        }

        return 0;
    }
}
