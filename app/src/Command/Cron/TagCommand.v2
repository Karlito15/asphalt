<?php

namespace App\Command\Cron;

use App\Entity\GarageApp;
use App\Entity\GarageUpgrade;
use App\Entity\SettingTag;
use App\Trait\Command\ConfigureTrait;
use App\Trait\Command\InitializeTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'asphalt:cron:tag',
    description: '',
    aliases: ['asphalt-cron-tag'],
    hidden: false,
)]
class TagCommand extends Command
{
    use InitializeTrait;
    use ConfigureTrait;

    protected static string $title = '::::: XXX :::::';

    public function __construct(
        private readonly ContainerInterface      $container,
        private readonly EntityManagerInterface  $entityManager,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Init variables
        $io     = new SymfonyStyle($input, $output);
        $manager = $this->entityManager;

        // Start
        $output->writeln(shell_exec('clear'));
        $io->section($this->getDescription());

        // Get Garage
        $garages = $manager->getRepository(GarageApp::class)->findAll();

        // Handler
        foreach ($garages as $garage) {
            $garageLevel  = $garage->getLevel();
            $garageEpic   = $garage->getEpic();
            $fullLevel    = $garage->getSettingLevel()->getLevel();
            $fullCommon   = $garage->getSettingLevel()->getCommon();
            $fullRare     = $garage->getSettingLevel()->getRare();
            $fullEpic     = $garage->getSettingLevel()->getEpic();
            /** @var GarageUpgrade $upgrades */
            $upgrades     = $garage->getUpgrade()->current();
            $speed        = $upgrades->getSpeed();
            $acceleration = $upgrades->getAcceleration();
            $handling     = $upgrades->getHandling();
            $nitro        = $upgrades->getNitro();
            $common       = $upgrades->getCommon();
            $rare         = $upgrades->getRare();
            $epic         = $upgrades->getEpic();

            $io->title($garage->getModel());
            // Blueprint
            if ($garageLevel === $fullLevel) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-blueprint']);
                $garage->addSettingTag($tag);
                $io->write('full Blueprint', true);
                $manager->persist($garage);
            }
            // Speed
            if ($garageLevel === $speed) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-speed']);
                $garage->addSettingTag($tag);
                $io->write('full Speed', true);
                $manager->persist($garage);
            }
            // Acceleration
            if ($garageLevel === $acceleration) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-acceleration']);
                $garage->addSettingTag($tag);
                $io->write('full Acceleration', true);
                $manager->persist($garage);
            }
            // Handling
            if ($garageLevel === $handling) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-handling']);
                $garage->addSettingTag($tag);
                $io->write('full Handling', true);
                $manager->persist($garage);
            }
            // Nitro
            if ($garageLevel === $nitro) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-nitro']);
                $garage->addSettingTag($tag);
                $io->write('full Nitro', true);
                $manager->persist($garage);
            }
            // Upgrades
            if (
                $garageLevel === $speed &&
                $garageLevel === $acceleration &&
                $garageLevel === $handling &&
                $garageLevel === $nitro
            ) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-upgrades']);
                $garage->addSettingTag($tag);
                $io->write('full Upgrades', true);
                $manager->persist($garage);
            }
            // Common
            if ($common === $fullCommon) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-common']);
                $garage->addSettingTag($tag);
                $io->write('full Common', true);
                $manager->persist($garage);
            }
            // Rare
            if ($rare === $fullRare) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-rare']);
                $garage->addSettingTag($tag);
                $io->write('full Rare', true);
                $manager->persist($garage);
            }
            // Imports
            if (
                $common === $fullCommon &&
                $rare === $fullRare
            ) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-imports']);
                $garage->addSettingTag($tag);
                $io->write('full Imports', true);
                $manager->persist($garage);
            }
            // Epic
            if ($epic === $fullEpic) {
                $tag = $manager->getRepository(SettingTag::class)->findOneBy(['slug' => 'full-epic']);
                $garage->addSettingTag($tag);
                $io->write('full Epic', true);
                $manager->persist($garage);
            }
            $manager->flush();
            exit();
        }

        return Command::SUCCESS;
    }
}
