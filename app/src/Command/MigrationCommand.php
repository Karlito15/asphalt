<?php

declare(strict_types=1);

namespace App\Command;

use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use App\Trait\Command\ResumeTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;

#[AsCommand(
    name: 'asphalt:database:migration',
    description: 'Exporte ou Importe toutes les données',
    aliases: ['asphalt-database-migration'],
    hidden: false,
)]
class MigrationCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use ResumeTrait;

    protected static string $title = '::::: Migration Datas :::::';

    public function __construct(
        private readonly ContainerInterface $container,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Choose Export or Import');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $output->writeln(shell_exec('clear'));
        $this->io->title(self::$title);
        $io->section($this->getDescription());

        // Execution time : start
        $this->stopwatch->start(self::$title);

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        // Commands
        if ($choice === 'import') {
            // the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:database:setting',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

            // the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:database:mission',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

            // the command name is passed as first argument
            $races = new ArrayInput([
                'command' => 'asphalt:database:race',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            // the command name is passed as first argument
            $inventories = new ArrayInput([
                'command' => 'asphalt:database:inventory',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $inventories->setInteractive(false);
            $this->getApplication()->doRun($inventories, $output);

            // the command name is passed as first argument
            $garages = new ArrayInput([
                'command' => 'asphalt:database:garage',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $garages->setInteractive(false);
            $this->getApplication()->doRun($garages, $output);

            // Delete Cache for Dashboard
            $filesystem = new Filesystem();
            $cache = $this->container->getParameter('kernel.project_dir') . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
            $filesystem->remove($cache);

            // Conclusion
            $io->success('Import terminé !');
            $result = true;
        } elseif ($choice === 'export') {
            // the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:database:setting',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

            // the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:database:mission',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

            // the command name is passed as first argument
            $races = new ArrayInput([
                'command' => 'asphalt:database:race',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            // the command name is passed as first argument
            $inventories = new ArrayInput([
                'command' => 'asphalt:database:inventory',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $inventories->setInteractive(false);
            $this->getApplication()->doRun($inventories, $output);

            // the command name is passed as first argument
            $garages = new ArrayInput([
                'command' => 'asphalt:database:garage',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $garages->setInteractive(false);
            $this->getApplication()->doRun($garages, $output);

            // Conclusion
            $io->success('Export terminé !');
            $result = true;
        } else {
            $result = false;
            $io->error('Houston we have a problem !');
        }

        // Execution time : stop
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
