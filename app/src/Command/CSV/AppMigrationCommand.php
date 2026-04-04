<?php

declare(strict_types=1);

namespace App\Command\CSV;

use App\Toolbox\Trait\Command\AllCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Throwable;

#[AsCommand(
    name: 'asphalt:csv:migration',
    description: 'Exporte ou Importe toutes les données',
    aliases: ['asphalt-csv-migration'],
    hidden: false,
)]
class AppMigrationCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Migration Datas :::::';

    protected static string $help  = 'Exporte ou Importe toutes les données';

    public function __construct(
        private readonly ParameterBagInterface $parameter,
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
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Export or Import ?');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        ### Execution time : start
        $this->stopwatch->start(self::$title);

        ### Question
        if (is_null($choice)) {
            $helper   = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or import datas ?', ['export', 'import'], 'export');
            $choice   = $helper->ask($input, $output, $question);
        }

        ### Commands
        if ($choice === 'import') {
            ### the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:csv:setting',
                'choice' => 'import'
            ]);
            ### disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

            ### the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:csv:mission',
                'choice' => 'import'
            ]);
            ### disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

            ### the command name is passed as first argument
            $races = new ArrayInput([
                'command' => 'asphalt:csv:race',
                'choice' => 'import'
            ]);
            ### disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            ### the command name is passed as first argument
            $inventories = new ArrayInput([
                'command' => 'asphalt:csv:inventory',
                'choice' => 'import'
            ]);
            ### disable interactive behavior for the greet command
            $inventories->setInteractive(false);
            $this->getApplication()->doRun($inventories, $output);

            ### the command name is passed as first argument
            $garages = new ArrayInput([
                'command' => 'asphalt:csv:garage',
                'choice' => 'import'
            ]);
            ### disable interactive behavior for the greet command
            $garages->setInteractive(false);
            $this->getApplication()->doRun($garages, $output);

            // Delete all Cache
            $cache = $this->parameter->get('folders.cache');
            $filesystem = new Filesystem();
            $filesystem->remove($cache);
            $io->info('Cache Deleted !');

            // Conclusion
            $io->success('Import terminé !');
            $result = true;
        } elseif ($choice === 'export') {
            ### the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:csv:setting',
                'choice' => 'export'
            ]);
            ### disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

            ### the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:csv:mission',
                'choice' => 'export'
            ]);
            ### disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

            ### the command name is passed as first argument
            $races = new ArrayInput([
                'command' => 'asphalt:csv:race',
                'choice' => 'export'
            ]);
            ### disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            ### the command name is passed as first argument
            $inventories = new ArrayInput([
                'command' => 'asphalt:csv:inventory',
                'choice' => 'export'
            ]);
            ### disable interactive behavior for the greet command
            $inventories->setInteractive(false);
            $this->getApplication()->doRun($inventories, $output);

            ### the command name is passed as first argument
            $garages = new ArrayInput([
                'command' => 'asphalt:csv:garage',
                'choice' => 'export'
            ]);
            ### disable interactive behavior for the greet command
            $garages->setInteractive(false);
            $this->getApplication()->doRun($garages, $output);

            // Conclusion
            $io->success('Export terminé !');
            $result = true;
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        // Execution time : stop
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
