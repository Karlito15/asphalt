<?php

declare(strict_types=1);

namespace App\Command;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Able\Command\ResumeAble;
use App\Entity\SettingBlueprint;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Entity\SettingLevel;
use App\Entity\SettingTag;
use App\Entity\SettingUnitPrice;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
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
    use ConfigureAble;
    use InitializeAble;
    use ResumeAble;

    protected static string $title = '::::: Truncate Tables :::::';

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
        /** Init variables */
        $io         = new SymfonyStyle($input, $output);
        $em         = $this->entityManager;
        $connection = $em->getConnection();

        /** Start */
        $io->section(self::getDefaultDescription());

        /** Execution time : start */
        $this->stopwatch->start(self::$title);

        /** Truncate */
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0');
        $connection->executeQuery('TRUNCATE ext_log_entries');
        $io->write('- Table vidé : ext_log_entries', true);
        $io->write('- Table vidé : messenger_messages', true);
        self::truncateTable(SettingBlueprint::class, $em, $io);
        self::truncateTable(SettingBrand::class, $em, $io);
        self::truncateTable(SettingClass::class, $em, $io);
        self::truncateTable(SettingLevel::class, $em, $io);
        self::truncateTable(SettingTag::class, $em, $io);
        self::truncateTable(SettingUnitPrice::class, $em, $io);
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');

        /** Execution time : stop */
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        /** Resume */
        self::resume($this->io, $duration);

        /** Conclusion */
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
