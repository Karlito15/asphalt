<?php

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Event\Setting\BrandEvent;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:setting-brand',
    description: 'Compte le nombre de voitures par marque',
    aliases: ['asphalt-cron-setting-brand'],
    hidden: false,
)]
class SettingBrandCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Counter Brand :::::';

    public function __construct(
		private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io = new SymfonyStyle($input, $output);

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());

        $garages = $this->entityManager->getRepository(GarageApp::class)->findAll();
        foreach ($garages as $garage) {
            $this->dispatcher->dispatch(new BrandEvent($garage));
        }

        // Conclusion
        $io->success($this->getDescription());

        return Command::SUCCESS;
    }
}
