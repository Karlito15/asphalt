<?php

declare(strict_types=1);

namespace App\Command\Cron\Count;

use App\Event\Setting\ClassEvent;
use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingClass;
use App\Toolbox\Trait\Command\AllCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
    name: 'asphalt:cron:count:class',
    description: 'Compte le nombre de voitures par Class',
    aliases: ['asphalt-cron-count-class'],
    hidden: false,
)]
class ClassCommand extends Command
{
    use AllCommand;

    protected static string $title = '::::: Counter Class :::::';

    protected static string $help  = 'Compte le nombre de voitures par Class';

    public function __construct(
		private readonly EntityManagerInterface   $entityManager,
        private readonly EventDispatcherInterface $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io        = new SymfonyStyle($input, $output);
        $manager   = $this->entityManager;
        $stopwatch = $this->stopwatch;

        // Execution time : start
        $stopwatch->start(self::$title);

        foreach (['D', 'C', 'B', 'A', 'S'] as $letter)
        {
            $class  = $this->getSettingClass($letter);
            $garage = $this->getGarage($class);
            $this->dispatcher->dispatch(new ClassEvent($garage));
            $io->text(sprintf('Setting Class %s is updated', $letter));
        }

        // Flush
        $manager->flush();

        // Execution time : stop
        $event      = $stopwatch->stop(self::$title);
        $duration   = $event->getDuration() / 1000;

        // Resume
        self::resume($this->io, $duration);

        return Command::SUCCESS;
    }

    /**
     * @param string $letter
     * @return SettingClass
     */
    private function getSettingClass(string $letter = 'S'): SettingClass
    {
        return $this->entityManager->getRepository(SettingClass::class)->findByClass($letter);
    }

    /**
     * @param SettingClass $class
     * @return GarageApp
     */
    private function getGarage(SettingClass $class): GarageApp
    {
        return $this->entityManager->getRepository(GarageApp::class)->findOneBy(['settingClass' => $class]);
    }
}
