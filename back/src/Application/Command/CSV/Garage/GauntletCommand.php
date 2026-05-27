<?php

declare(strict_types=1);

namespace App\Application\Command\CSV\Garage;

use App\Domain\Repository\InventoryAppRepository;
use App\Infrastructure\Command\Helpers\Directory;
use App\Infrastructure\Command\Traits\{
    ConfigureCommand,
    CSVCommand,
    FileSystemCommand,
    InitializeCommand,
    InteractCommand,
    QuestionCommand
};
use App\Infrastructure\Data\CSV;
use App\Infrastructure\Data\Garage\App;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'asphalt:csv:garage:gauntlet',
    description: "Toutes les données pour le Garage",
    aliases: ['asphalt-csv-garage-gauntlet'],
    hidden: false,
)]
class GauntletCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand, QuestionCommand;
    use CSVCommand, FileSystemCommand;

    protected static string $title    = '::::: Garages Gauntlet Datas :::::';

    protected static string $help     = '';

    private static string $database   = 'csv.folders.database.datas';
    private static string $file       = 'csv.file.garage.gauntlet';
    private static string $header     = 'csv.header.garage.gauntlet';
    private static string $folderName = 'garages';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly InventoryAppRepository $repository,
    )
    {
        parent::__construct();
    }

    /**
     * ConfigureCommand your CLI Application
     */
    protected function configure(): void
    {
        parent::configure();

        $this->addArgument( name: 'choice', mode: InputArgument::OPTIONAL, description: 'Export or Import ?');
    }

    /**
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get(static::$database);
//        $logger     = $this->logger;
        $result     = false;

        ### Find Last Directory
        $folder     = Directory::getLastDirectory($database);

        ### QuestionCommand
        $choice     = self::Question(choice: $choice, input: $input, output: $output);

        ### Services Datas
        if ($choice === 'import') {
            ### Import
            $this->import($folder, $io);
            $io->newLine(2);
            $io->success("Les données pour le Garage sont importées");
            $result = true;
        }

        if ($choice === 'export') {
            ### Export
            $this->export($database);
            $io->newLine(2);
            $io->success("Les données pour le Garage sont exportées");
            $result = true;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }

    /** PRIVATE METHODS */

    /**
     * @param string $folder
     * @param SymfonyStyle $io
     * @return void
     * @throws Exception
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws \Doctrine\DBAL\Exception
     */
    private function import(string $folder, SymfonyStyle $io): void
    {
        /** Start Import */
        $filepath = Directory::normalize($folder . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $fs = new Filesystem();

        if ($fs->exists($filepath)) {
            ### Read CSV File
            $records = CSV::toArray($filepath);

            ### Progress Bar Start
            $io->progressStart(count($records));

            ### Handling
            foreach ($records as $record) {
                ### Progress Bar +1
                $io->progressAdvance();

                ### Create Entity
                $entity = App::createGauntlet($this->entityManager, $record);

                ### Persist Entity
                $this->entityManager->persist($entity);
            }

            ### Progress Bar Stop
            $io->progressFinish();

            $connection = $this->entityManager->getConnection();
            $connection->beginTransaction();
            try {
                ### Flush
                $this->entityManager->flush();
                $this->entityManager->clear();
                $connection->commit();
            } catch (\Exception $e) {
                ### Rollback
                $connection->rollback();
                $io->newLine(3);
                $this->logger->error('Erreur lors du flush');
                $this->logger->error('CSV : ' . $filepath);
                $this->logger->error($e->getMessage());
            }
        } else {
            $io->error($filepath);
            throw new RuntimeException('CSV File does not exist');
        }
        /** End Import */
    }
}
