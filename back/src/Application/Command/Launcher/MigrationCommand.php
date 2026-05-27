<?php

declare(strict_types=1);

namespace App\Application\Command\Launcher;

use App\Infrastructure\Command\Traits\{
    ConfigureCommand,
    InitializeCommand,
    InteractCommand,
    QuestionCommand
};
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'asphalt:csv:migration',
    description: 'Exporte ou Importe toutes les données',
    aliases: ['asphalt-csv-migration'],
    hidden: false,
)]
class MigrationCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand, QuestionCommand;

    protected static string $title = '::::: Migration Datas :::::';

    protected static string $help  = 'Exporte ou Importe toutes les données';

    public function __construct(
        private readonly ParameterBagInterface $parameter,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument( name: 'choice', mode: InputArgument::OPTIONAL, description: 'Export or Import ?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}
