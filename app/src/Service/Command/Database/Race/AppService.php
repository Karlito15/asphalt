<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Race;

use App\Interface\DatabaseServiceInterface;
use App\Persistence\Entity\RaceApp;
use App\Persistence\Entity\RaceMode;
use App\Persistence\Entity\RaceSeason;
use App\Persistence\Entity\RaceTime;
use App\Persistence\Entity\RaceTrack;
use App\Persistence\Repository\RaceAppRepository;
use App\Service\Command\MigrationService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'races';

    private static string $file = 'app.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceAppRepository      $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     * @throws Exception
     */
    public function import(SymfonyStyle $io, string $directory): void
    {
        $io->text('From CSV : Race App');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Race App');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return RaceApp
     */
    public function createEntity(array $datas): RaceApp
    {
        /** @var RaceMode $mode */
        $mode   = $this->entityManager->getRepository(RaceMode::class)->findOneBy(['name' => $datas['Mode']]);
        /** @var RaceSeason $season */
        $season = $this->entityManager->getRepository(RaceSeason::class)->findOneBy(['name' => $datas['Season']]);
        /** @var RaceTime $time */
        $time   = $this->entityManager->getRepository(RaceTime::class)->findOneBy(['name' => $datas['Time']]);
        /** @var RaceTrack $track */
        $track  = $this->entityManager->getRepository(RaceTrack::class)->findOneBy(['nameEnglish' => $datas['English']]);
        if ($track === null) {
            echo $datas['English'];
            exit();
        }
        $entity = new RaceApp();
        $entity
            ->setRaceOrder((int) $datas['RaceOrder'])
            ->setFinished(true)
            ->setMode($mode)
            ->setSeason($season)
            ->setTime($time)
            ->setTrack($track)
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.app');
    }
}
