<?php

declare(strict_types=1);

namespace App\Application\Command\CSV\Garage;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Command\Helpers\Directory;
use App\Infrastructure\Command\Traits\{
    ConfigureCommand,
    InitializeCommand,
    InteractCommand,
    QuestionCommand
};
use App\Infrastructure\Data\Garage\App;
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
    name: 'asphalt:csv:garage:balance',
    description: "Toutes les données pour le Garage",
    aliases: ['asphalt-csv-garage-balance'],
    hidden: false,
)]
class BalanceCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand, QuestionCommand;

    protected static string $title    = '::::: Garages Balance Datas :::::';

    protected static string $help     = '';

    private static string $database   = 'csv.folders.database.datas';
    private static string $file       = '';
    private static string $header     = '';
    private static string $folderName = 'garages';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get(static::$database);
//        $logger     = $this->logger;
        $result     = false;

        ### QuestionCommand
        $choice     = self::Question(choice: $choice, input: $input, output: $output);

        ### Services Datas
        if ($choice === 'import') {
            ### Import
            $this->import($io);
            $io->newLine(2);
            $io->success("Les données pour le Garage sont importées");
            $result = true;
        }

        if ($choice === 'export') {
            ### Export
            // $this->export($database);
            $io->newLine(2);
            $io->success("Les données pour le Garage sont exportées");
            $result = true;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }

    /** PRIVATE METHODS */

    /**
     * @param SymfonyStyle $io
     * @return void
     * @throws Exception
     */
    private function import(SymfonyStyle $io): void
    {
        /** Start Import */
        ### XXX
        $garages = $this->entityManager->getRepository(GarageApp::class)->findBy([], ['id' => 'ASC']);

        ### Progress Bar Start
        $io->progressStart(count($garages));

        ### Handling
        foreach ($garages as $record) {
            $datas = [
                'Brand' => $record->getSettingBrand()->getName(),
                'Model' => $record->getModel(),
            ];

            ### Progress Bar +1
            $io->progressAdvance();

            ### Create Entity
            $amount = App::createBalanceAmount($this->entityManager, $datas);
            $due    = App::createBalanceDue($this->entityManager, $datas);
            $paid   = App::createBalancePaid($this->entityManager, $datas);

            ### Persist Entity
            $this->entityManager->persist($amount);
            $this->entityManager->persist($due);
            $this->entityManager->persist($paid);
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
            $this->logger->error($e->getMessage());
        }
        /** End Import */
    }
}
