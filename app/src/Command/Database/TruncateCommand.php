<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\GarageEvo;
use App\Persistence\Entity\GarageGauntlet;
use App\Persistence\Entity\GarageRank;
use App\Persistence\Entity\GarageStatActual;
use App\Persistence\Entity\GarageStatMax;
use App\Persistence\Entity\GarageStatMin;
use App\Persistence\Entity\GarageStatus;
use App\Persistence\Entity\GarageUpgrade;
use App\Persistence\Entity\InventoryApp;
use App\Persistence\Entity\MissionApp;
use App\Persistence\Entity\MissionTask;
use App\Persistence\Entity\MissionType;
use App\Persistence\Entity\RaceApp;
use App\Persistence\Entity\RaceMode;
use App\Persistence\Entity\RaceRegion;
use App\Persistence\Entity\RaceSeason;
use App\Persistence\Entity\RaceTime;
use App\Persistence\Entity\RaceTrack;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Entity\SettingLevel;
use App\Persistence\Entity\SettingTag;
use App\Persistence\Entity\SettingUnitPrice;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use KarlitoWeb\Toolbox\Trait\Command\ConfigureTrait;
use KarlitoWeb\Toolbox\Trait\Command\InitializeTrait;
use KarlitoWeb\Toolbox\Trait\Command\ResumeTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:database:truncate',
    description: 'Vider la base de données',
    aliases: ['asphalt-database-truncate'],
    hidden: false,
)]
class TruncateCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use ResumeTrait;

    protected static string $title = '::::: Truncate Tables :::::';

    protected static string $help  = 'Vider la base de données';

    /**
     * @param ContainerInterface $container
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly ContainerInterface $container,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
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
        $em         = $this->entityManager;
        $connection = $em->getConnection();

        // Execution time : start
        $this->stopwatch->start(self::$title);

        // Truncate
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');
        // $connection->executeQuery('TRUNCATE ext_log_entries');
        // $io->write('- Table vidé : ext_log_entries', true);
        self::truncateTable(GarageApp::class, $em, $io);
        self::truncateTable(GarageBlueprint::class, $em, $io);
        self::truncateTable(GarageEvo::class, $em, $io);
        self::truncateTable(GarageGauntlet::class, $em, $io);
        self::truncateTable(GarageRank::class, $em, $io);
        self::truncateTable(GarageStatActual::class, $em, $io);
        self::truncateTable(GarageStatMax::class, $em, $io);
        self::truncateTable(GarageStatMin::class, $em, $io);
        self::truncateTable(GarageStatus::class, $em, $io);
        self::truncateTable(GarageUpgrade::class, $em, $io);
        self::truncateTable(InventoryApp::class, $em, $io);
        self::truncateTable(MissionApp::class, $em, $io);
        self::truncateTable(MissionTask::class, $em, $io);
        self::truncateTable(MissionType::class, $em, $io);
        self::truncateTable(RaceApp::class, $em, $io);
        self::truncateTable(RaceMode::class, $em, $io);
        self::truncateTable(RaceRegion::class, $em, $io);
        self::truncateTable(RaceSeason::class, $em, $io);
        self::truncateTable(RaceTime::class, $em, $io);
        self::truncateTable(RaceTrack::class, $em, $io);
        self::truncateTable(SettingBlueprint::class, $em, $io);
        self::truncateTable(SettingBrand::class, $em, $io);
        self::truncateTable(SettingClass::class, $em, $io);
        self::truncateTable(SettingLevel::class, $em, $io);
        self::truncateTable(SettingTag::class, $em, $io);
        self::truncateTable(SettingUnitPrice::class, $em, $io);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');

        // Execution time : stop
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        // self::resume($this->io, $duration);

        // Conclusion
        $io->success('La base de données est vide');

        return Command::SUCCESS;
    }

    /**
     * @param string $tableName
     * @param EntityManagerInterface $em
     * @param SymfonyStyle $io
     * @return void
     * @throws Exception
     */
    private static function truncateTable(
        string $tableName,
        EntityManagerInterface $em,
        SymfonyStyle $io
    ): void
    {
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->executeQuery(
            $dbPlatform->getTruncateTableSql($em->getClassMetadata($tableName)->getTableName())
        );
        $io->write('--- Table vidé : ' . $em->getClassMetadata($tableName)->getTableName(), true);
    }
}
