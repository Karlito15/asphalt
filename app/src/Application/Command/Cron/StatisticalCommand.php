<?php

declare(strict_types=1);

namespace App\Application\Command\Cron;

use App\Infrastructure\Event\Garage\StatisticalEvent;
use App\Infrastructure\Command\Traits\{
    ConfigureCommand,
    InitializeCommand,
    InteractCommand
};
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:statistical',
    description: 'Mets à jour les Stats',
    aliases: ['asphalt-cron-statistical'],
    hidden: false,
)]
class StatisticalCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand;

    protected static string $title    = '::::: Cron Statistical :::::';

    protected static string $help     = 'Mets à jour les Stats';

    public function __construct(
        private readonly ContainerInterface         $container,
        private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        ### Init variables
        $io = new SymfonyStyle($input, $output);
        $manager    = $this->entityManager;
        $dispatcher = $this->dispatcher;

        ### Event
        $dispatcher->dispatch(new StatisticalEvent());

        ### Flush
        $manager->flush();
        $manager->clear();

        $io->success('Finished !');

        return Command::SUCCESS;
    }
}
