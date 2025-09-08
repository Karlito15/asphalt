<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use App\Entity\AppGarage;
use App\Entity\AppInventory;
use App\Entity\AppMission;
use App\Entity\AppRace;
use App\Entity\GarageBlueprint;
use App\Entity\GarageBoolean;
use App\Entity\GarageRank;
use App\Entity\GarageStatMax;
use App\Entity\GarageStatMin;
use App\Entity\GarageUpgrade;
use App\Entity\MissionTask;
use App\Entity\MissionType;
use App\Entity\RaceMode;
use App\Entity\RaceRegion;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use App\Entity\RaceTrack;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingUnitPrice;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:database:clear',
    description: 'Vider la base de données',
    aliases: ['asphalt-database-clear'],
    hidden: false,
)]
class ClearCommand extends Command
{
    use CommandAble;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        // Clear Display
        self::clearScreen();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io               = new SymfonyStyle($input, $output);
        $em               = $this->entityManager;
        $connection       = $em->getConnection();

        // Start
        $io->section(self::getDefaultDescription());

        // Truncate
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');
        $connection->executeQuery('TRUNCATE ext_log_entries');
        $io->write('- Table vidé : ext_log_entries', true);
        self::truncateTable(AppGarage::class, $em, $io);
        self::truncateTable(AppInventory::class, $em, $io);
        self::truncateTable(AppMission::class, $em, $io);
        self::truncateTable(AppRace::class, $em, $io);
        self::truncateTable(GarageBlueprint::class, $em, $io);
        self::truncateTable(GarageBoolean::class, $em, $io);
        self::truncateTable(GarageRank::class, $em, $io);
        self::truncateTable(GarageStatMax::class, $em, $io);
        self::truncateTable(GarageStatMin::class, $em, $io);
        self::truncateTable(GarageUpgrade::class, $em, $io);
        self::truncateTable(MissionTask::class, $em, $io);
        self::truncateTable(MissionType::class, $em, $io);
        self::truncateTable(RaceMode::class, $em, $io);
        self::truncateTable(RaceRegion::class, $em, $io);
        self::truncateTable(RaceSeason::class, $em, $io);
        self::truncateTable(RaceTime::class, $em, $io);
        self::truncateTable(RaceTrack::class, $em, $io);
        self::truncateTable(SettingBlueprint::class, $em, $io);
        self::truncateTable(SettingBrand::class, $em, $io);
        self::truncateTable(SettingClass::class, $em, $io);
        self::truncateTable(SettingLevel::class, $em, $io);
        self::truncateTable(SettingUnitPrice::class, $em, $io);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');

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
        $io->write('- Table vidé : ' . $em->getClassMetadata($tableName)->getTableName(), true);
    }
}
