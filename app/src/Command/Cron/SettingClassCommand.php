<?php

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Entity\SettingClass;
use App\Event\Setting\ClassEvent;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsCommand(
	name: 'asphalt:cron:setting-class',
	description: 'Compte le nombre de voitures par Class',
	aliases: ['asphalt-cron-setting-class'],
	hidden: false,
)]
class SettingClassCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;

    protected static string $title = '::::: Counter Class :::::';

    public function __construct(
		private readonly EntityManagerInterface     $entityManager,
        private readonly EventDispatcherInterface   $dispatcher,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Choose a Class');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init Variables
        $io = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to update a Class ?', ['D', 'C', 'B', 'A', 'S'], 'S');
            $choice = $helper->ask($input, $output, $question);
        }

        // Update Setting Class
        switch ($choice) :
            case 'D':
                $class  = $this->getSettingClass($choice);
                $garage = $this->getGarage($class);
                $this->dispatcher->dispatch(new ClassEvent($garage));
                $io->text('Setting Class D is updated');
                $result = true;
                break;
            case 'C':
                $class  = $this->getSettingClass($choice);
                $garage = $this->getGarage($class);
                $this->dispatcher->dispatch(new ClassEvent($garage));
                $io->text('Setting Class C is updated');
                $result = true;
                break;
            case 'B':
                $class  = $this->getSettingClass($choice);
                $garage = $this->getGarage($class);
                $this->dispatcher->dispatch(new ClassEvent($garage));
                $io->text('Setting Class B is updated');
                $result = true;
                break;
            case 'A':
                $class  = $this->getSettingClass($choice);
                $garage = $this->getGarage($class);
                $this->dispatcher->dispatch(new ClassEvent($garage));
                $io->text('Setting Class A is updated');
                $result = true;
                break;
            case 'S':
                $class  = $this->getSettingClass($choice);
                $garage = $this->getGarage($class);
                $this->dispatcher->dispatch(new ClassEvent($garage));
                $io->text('Setting Class S is updated');
                $result = true;
                break;
            default:
                $io->text('default');
                $result = false;
                $io->error('Houston we have a problem !');
                break;
        endswitch;

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }

    /**
     * @param string $letter
     * @return SettingClass
     */
    private function getSettingClass(string $letter = 'S'): SettingClass
    {
        return $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $letter]);
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
