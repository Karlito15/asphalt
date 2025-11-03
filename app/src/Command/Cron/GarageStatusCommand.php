<?php

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Event\Garage\UpdateEvent;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'asphalt:cron:status',
    description: '...',
    aliases: ['asphalt-cron-status'],
    hidden: false,
)]
class GarageStatusCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Status :::::';

    public function __construct(
        private readonly ContainerInterface         $container,
        private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io = new SymfonyStyle($input, $output);

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());

        $garages = $this->entityManager->getRepository(GarageApp::class)->findAll();
        foreach ($garages as $garage) {
            // Event
            $this->dispatcher->dispatch(new UpdateEvent($garage));
        }
        $this->entityManager->flush();
        $this->entityManager->clear();


        // Delete all Cache
        $filesystem = new Filesystem();
        $cache = $this->container->getParameter('kernel.project_dir') .
            DIRECTORY_SEPARATOR . 'public' .
            DIRECTORY_SEPARATOR . 'cache' .
            DIRECTORY_SEPARATOR;
        $filesystem->remove($cache);

        // Conclusion
        $io->success($this->getDescription());

        return Command::SUCCESS;
    }
}
