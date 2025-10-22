<?php

declare(strict_types=1);

namespace App\Command\Database;

use App\Service\Database\Setting\BlueprintService;
use App\Service\Database\Setting\BrandService;
use App\Service\Database\Setting\ClassService;
use App\Service\Database\Setting\LevelService;
use App\Service\Database\Setting\TagService;
use App\Service\Database\Setting\UnitPriceService;
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

#[AsCommand(
    name: 'asphalt:database:setting',
    description: 'Toutes les données pour les Settings',
    aliases: ['asphalt-database-setting'],
    hidden: false,
)]
class SettingsCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly BlueprintService       $blueprint,
        private readonly BrandService           $brand,
        private readonly ClassService           $class,
        private readonly LevelService           $level,
        private readonly TagService             $tag,
        private readonly UnitPriceService       $unitPrice,
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
            $this->blueprint->import($io);
            $this->brand->import($io);
            $this->class->import($io);
            $this->level->import($io);
            $this->tag->import($io);
            $this->unitPrice->import($io);
            $io->info('Import SETTING terminé');
            $result = true;
        } elseif ($choice === 'export') {
            $this->unitPrice->export($io);
            $this->tag->export($io);
            $this->level->export($io);
            $this->class->export($io);
            $this->brand->export($io);
            $this->blueprint->export($io);
            $io->info('Les fichiers ont été créés');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
