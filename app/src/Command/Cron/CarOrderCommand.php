<?php

declare(strict_types=1);

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Entity\SettingClass;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\File\CSVTrait;
use App\Trait\Service\File\DirectoryTrait;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'asphalt:cron:order-car',
    description: 'Toutes les données pour la colonne "Car Order" du Garage',
    aliases: ['asphalt-cron-order-car'],
    hidden: false,
)]
class CarOrderCommand extends Command
{
    use ConfigureTrait;
    use InitializeTrait;
    use DirectoryTrait;
    use CSVTrait;
    use GarageServiceTrait;

    protected static string $title = '::::: Order Car :::::';

    protected static string $folder = 'cron' . DIRECTORY_SEPARATOR . 'order-car-by-class';

    protected static string $file = 'class-XXX.csv';

    public function __construct(
        private readonly ContainerInterface     $container,
        private readonly EntityManagerInterface $entityManager,
        private readonly ParameterBagInterface  $parameter,
    )
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        parent::configure();
        $this->addArgument('choice', InputArgument::OPTIONAL, 'Choose Export or Import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io     = new SymfonyStyle($input, $output);
        $choice = $input->getArgument('choice');

        // Start
        $io->title(self::$title);
        $io->section($this->getDescription());

        // Question
        if (is_null($choice)) {
            $helper = $this->getHelper('question');
            $question = new ChoiceQuestion('Do you want to export or update datas ?', ['export', 'update'], 'export');
            $choice = $helper->ask($input, $output, $question);
        }

        // Services Datas
        if ($choice === 'update') {
            $this->update();
            $result = true;
            $io->info('La Base de Donnée est à jour');
        } elseif ($choice === 'export') {
            $this->export();
            $result = true;
            $io->info('Les fichiers ont été créés');
        } else {
            $io->error('Houston we have a problem !');
            $result = false;
        }

        return ($result) ? Command::SUCCESS : Command::FAILURE;
    }

    /**
     * @return void
     */
    private function update(): void
    {
        $classes = ['D', 'C', 'B', 'A', 'S'];

        foreach ($classes as $class) {
            /** SettingClass */
            $settingClass = $this->getClass($class);

            /** Get Filepath */
            $file = str_replace("XXX", $class, self::$file);
            $csv  = $this->getCSVFile($file, self::$folder);

            /** Read File */
            $rows = self::readFile($csv);

            /** Update Garage */
            foreach ($rows as $row) {
                if (is_null($row['Brand'])) {
                    throw new RuntimeException('Brand cannot be null :: ' . json_encode($row));
                }
                if (is_null($row['Model'])) {
                    throw new RuntimeException('Model cannot be null :: ' . json_encode($row));
                }
                /** Find Car */
                $garage = $this->findGarage($row['Brand'], $row['Model']);
                $garage->setCarOrder($this->convertStringToInteger($row['Order']));

            }
            /** Flush Rows */
            $this->entityManager->flush();
            $this->entityManager->clear();

            $this->io->comment($file . ' is finish !');
        }
    }

    /**
     * @return void
     */
    private function export(): void
    {
        $classes = ['D', 'C', 'B', 'A', 'S'];

        foreach ($classes as $class) {
            /** SettingClass */
            $settingClass = $this->getClass($class);

            /** Garage by Class */
            $garages = $this->getGarageByClass($settingClass);

            /** Extract Garage */
            $rows = [];
            foreach ($garages as $garage) {
                $rows[] = ['Order' => $garage->getCarOrder(), 'Brand' => $garage->getSettingBrand()->getName(), 'Model' => $garage->getModel()];
            }

            /** Get Filepath */
            $csv = $this->getCSVFile(str_replace("XXX", $class, self::$file), self::$folder);

            self::writeFile($csv, $this->getHeader(), $rows);
        }
    }

    /**
     * @param string $letter
     * @return SettingClass
     */
    private function getClass(string $letter): SettingClass
    {
        return $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $letter]);
    }

    /**
     * @param SettingClass $settingClass
     * @return GarageApp[]
     */
    private function getGarageByClass(SettingClass $settingClass): array
    {
        return $this->entityManager->getRepository(GarageApp::class)->findBy(['settingClass' => $settingClass], ['carOrder' => 'ASC']);
    }

    /**
     * @return string[]
     */
    private function getHeader(): array
    {
        return ['Order', 'Brand', 'Model'];
    }
}
