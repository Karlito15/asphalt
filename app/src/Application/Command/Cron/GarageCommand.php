<?php

declare(strict_types=1);

namespace App\Application\Command\Cron;

use App\Domain\Entity\GarageApp;
use App\Infrastructure\Event\Garage\AppEvent;
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
    name: 'asphalt:cron:garage',
    description: 'Mets à jour la Voiture',
    aliases: ['asphalt-cron-garage'],
    hidden: false,
)]
class GarageCommand extends Command
{
    use ConfigureCommand, InitializeCommand, InteractCommand;

    protected static string $title    = '::::: Cron Garage :::::';

    protected static string $help     = 'Mets à jour la Voiture';

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
        $stopwatch  = $this->stopwatch;
        $dispatcher = $this->dispatcher;

        ### Execution time : start
        $stopwatch->start(self::$title);

        ### Get Datas
        $garages   = $manager->getRepository(GarageApp::class)->findBy([], ['id' => 'ASC']);

        ### Progress Bar : Star
        $io->progressStart(count($garages));
        $io->newLine();
        foreach ($garages as $garage) {
            ### Event
            $dispatcher->dispatch(new AppEvent($garage));

            ### Progress Bar : +1
            $io->progressAdvance();
        }

        ### Flush
        $manager->flush();
        $manager->clear();

        ### Progress Bar : Stop
        $io->progressFinish();

        $io->success('Finished !');

        return Command::SUCCESS;
    }
}
