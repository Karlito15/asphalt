<?php

namespace App\Service\Database\Race;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\RaceApp;
use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use App\Entity\RaceTrack;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\RaceAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'races';

    private static string $file = 'app.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceAppRepository          $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : App Race');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : App Race');
        $this->makeAnExport();
    }

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
            echo $datas['NameEnglish'];
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

    public function getHeader(): array
    {
        return ['Season', 'RaceOrder', 'Mode', 'Time', 'English'];
    }
}
