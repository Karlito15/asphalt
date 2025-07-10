<?php

declare(strict_types=1);

namespace App\Command;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Able\Command\ResumeAble;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:database:migration',
    description: 'Exporte ou Importe toutes les données',
    aliases: ['asphalt-database-migration'],
    hidden: false,
)]
class MigrationCommand extends Command
{
    use ConfigureAble;
    use InitializeAble;
    use ResumeAble;

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
        $this->addArgument(
            'choice',
            InputArgument::OPTIONAL,
            'Choose Export or Import'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** Init variables */
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        /** Start */
        $output->writeln(shell_exec('clear'));
        $this->io->title(self::$title);
        $io->section((string) self::getDefaultDescription());

        /** Execution time : start */
        $this->stopwatch->start(self::$title);

        /** Question */
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion(
                'Do you want to export or import datas ?',
                ['export', 'import'],
                'export',
            );

            $choice = $helper->ask($input, $output, $question);
        }

        /** Commands */
        if ($choice === 'import') {
            // the command name is passed as first argument
            $settings = new ArrayInput([
                'command' => 'asphalt:database:setting',
                'choice' => 'import'
            ]);
            // disable interactive behavior for the greet command
            $settings->setInteractive(false);
            $this->getApplication()->doRun($settings, $output);

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

            // Conclusion
            $io->success('Export terminé !');
        } else {
            $result = false;
            $io->error('Houston we have a problem !');
        }

        /** Execution time : stop */
        $event      = $this->stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        /** Resume */
        self::resume($this->io, $duration);

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
