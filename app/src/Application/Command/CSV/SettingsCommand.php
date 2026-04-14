<?php

namespace App\Application\Command\CSV;

use App\Application\Service\Command\{AllCommand, QuestionCommand};
use App\Application\Service\CSV\Setting\{BlueprintCSV, BrandCSV, ClassCSV, LevelCSV, TagCSV, UnitPriceCSV};
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
    name: 'asphalt:csv:setting',
    description: 'Toutes les données pour les Settings',
    aliases: ['asphalt-csv-setting'],
    hidden: false,
)]
class SettingsCommand extends Command
{
    use AllCommand, QuestionCommand;

    protected static string $title = '::::: Settings Datas :::::';

    protected static string $help  = '';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly BlueprintCSV           $blueprint,
        private readonly BrandCSV               $brand,
        private readonly ClassCSV               $class,
        private readonly LevelCSV               $level,
        private readonly TagCSV                 $tag,
        private readonly UnitPriceCSV           $unitPrice,
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
        $io         = new SymfonyStyle($input, $output);
        $choice     = $input->getArgument('choice');
        $database   = $this->parameter->get('csv.folders.database');
        $logger     = $this->logger;
        $result     = false;

        ### Find Last Directory
        $folder     = Folder::getLastDirectory($database);

        ### Question
        $choice     = self::Question(choice: $choice, input: $input, output: $output);

        ### Services Datas
        if ($choice === 'import') {
            $io->write('Blueprint', true);
            $this->blueprint->import($io, $folder);
            $io->write('Brand', true);
            $this->brand->import($io, $folder);
            $io->write('Class', true);
            $this->class->import($io, $folder);
            $io->write('Level', true);
            $this->level->import($io, $folder);
            $io->write('Tag', true);
            $this->tag->import($io, $folder);
            $io->write('UnitPrice', true);
            $this->unitPrice->import($io, $folder);
            $io->success("Les données pour les Settings sont importées");
            $result = true;
        } elseif ($choice === 'export') {
            $this->unitPrice->export($io, $database);
            $this->tag->export($io, $database);
            $this->level->export($io, $database);
            $this->class->export($io, $database);
            $this->brand->export($io, $database);
            $this->blueprint->export($io, $database);
            $io->success("Les données pour les Settings sont exportées");
            $result = true;
        } else {
            $logger->error('Fail to Import Inventory');
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
