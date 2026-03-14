<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Entity\GarageGauntlet;
use App\Persistence\Entity\GarageRank;
use App\Persistence\Entity\GarageStatActual;
use App\Persistence\Entity\GarageStatMax;
use App\Persistence\Entity\GarageStatMin;
use App\Persistence\Entity\GarageStatus;
use App\Persistence\Entity\GarageStatusControl;
use App\Persistence\Entity\GarageUpgrade;
use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:database:truncate:garage',
    description: 'Vider la base de données',
    aliases: ['asphalt-database-truncate-garage'],
    hidden: false,
)]
class TruncateGarageCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Truncate Tables :::::';

    protected static string $help  = 'Vider la base de données';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
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
        $this->truncateTable(GarageApp::class, $io);
        $this->truncateTable(GarageBlueprint::class, $io);
        $this->truncateTable(GarageGauntlet::class, $io);
        $this->truncateTable(GarageRank::class, $io);
        $this->truncateTable(GarageStatActual::class, $io);
        $this->truncateTable(GarageStatMax::class, $io);
        $this->truncateTable(GarageStatMin::class, $io);
        $this->truncateTable(GarageStatus::class, $io);
        $this->truncateTable(GarageStatusControl::class, $io);
        $this->truncateTable(GarageUpgrade::class, $io);
//        $this->truncateTable(SettingBlueprint::class, $io);
//        $this->truncateTable(SettingBrand::class, $io);
//        $this->truncateTable(SettingClass::class, $io);
//        $this->truncateTable(SettingLevel::class, $io);
//        $this->truncateTable(SettingTag::class, $io);
//        $this->truncateTable(SettingUnitPrice::class, $io);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');

        // Execution time : stop
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        // Conclusion
        $io->warning('Execution Time : ' . $duration);
        $io->success('La base de données est vide');

        return Command::SUCCESS;
    }

    /**
     * @param string $tableName
     * @param SymfonyStyle $io
     * @return void
     * @throws Exception
     */
    private function truncateTable(
        string $tableName,
        SymfonyStyle $io
    ): void
    {
        $connection = $this->entityManager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->executeQuery(
            $dbPlatform->getTruncateTableSql($this->entityManager->getClassMetadata($tableName)->getTableName())
        );
        $io->write('--- Table vidé : ' . $this->entityManager->getClassMetadata($tableName)->getTableName(), true);
    }
}
