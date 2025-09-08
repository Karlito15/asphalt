<?php

namespace App\Command\Database;

use App\Able\CommandAble;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'asphalt:database:all',
    description: 'Exporte ou Importe toutes les données',
    aliases: ['a:d:a', 'asphalt-database-all'],
    hidden: false,
)]
class AppCommand extends Command
{
    use CommandAble;

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
		// Clear the console
		// self::clearScreen();

        // configure an argument
        $this->addArgument(
            'choice',
            InputArgument::OPTIONAL,
            'Export or Import Settings'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');
        $result = false;

        // Start
        $io->section((string) self::getDefaultDescription());

        // Introduction
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        // Services
        if ($choice == 'import') {
            // the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:database:setting',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

            // the command name is passed as first argument
            $races = new ArrayInput([
                'command' => 'asphalt:database:race',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            // the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:database:mission',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

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
            $result = true;

            // Conclusion
            $io->success('Import terminé !');
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
            $races = new ArrayInput([
                'command' => 'asphalt:database:race',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $races->setInteractive(false);
            $this->getApplication()->doRun($races, $output);

            // the command name is passed as first argument
            $missions = new ArrayInput([
                'command' => 'asphalt:database:mission',
                'choice' => 'export'
            ]);
            // disable interactive behavior for the greet command
            $missions->setInteractive(false);
            $this->getApplication()->doRun($missions, $output);

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
            $result = true;

            // Conclusion
            $io->success('Export terminé !');
        } else {
            $result = false;
            $io->error('Houston we have a problem !');
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
