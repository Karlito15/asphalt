<?php

//declare(strict_types=1);

namespace App\Command\Database;

use App\Able\Command\ConfigureAble;
use App\Able\Command\InitializeAble;
use App\Entity\GarageApp;
use App\Entity\GarageStatMax;
use App\Entity\SettingTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:database:garagetag',
    description: 'Add a short description for your command',
    aliases: ['asphalt-database-garagetag'],
    hidden: false,
)]
class GarageTagCommand extends Command
{
    use ConfigureAble;
    use InitializeAble;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly EntityManagerInterface  $entityManager,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        parent::configure();
//        $this->addArgument(
//            'choice',
//            InputArgument::OPTIONAL,
//            'Choose Export or Import'
//        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = true;
        // Init variables
        $io     = new SymfonyStyle($input, $output);
//        $choice = $input->getArgument('choice');
        $manager = $this->entityManager;

        // Start
        $io->section($this->getDescription());

        // Question
//        if (is_null($choice)) {
//            $helper = $this->getHelper('question');
//            $question = new ChoiceQuestion(
//                'Do you want to export or import datas ?',
//                ['export', 'import'],
//                'export',
//            );
//
//
//            $choice = $helper->ask($input, $output, $question);
//        }

        // Tout le Garage
        $garages = $manager->getRepository(GarageApp::class)->findAll();
        foreach ($garages as $garage) {
            /**
             * To Unlock
             * @var GarageStatMax $statMax
             */
            $collection = $garage->getStatMax()->getValues();
            $statMax = $collection[0]->getAverage();
            $median = $garage->getSettingClass()->getMedian();
            if ($statMax >= $median) {
                // Add Tag 'To Unlock'
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'to-unlock']);
                $garage->addSettingTag($tag);
            }

//            $manager->flush();
        }


        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }
}
