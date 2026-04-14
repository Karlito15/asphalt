<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Race;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\{RaceApp, RaceMode, RaceSeason, RaceTime, RaceTrack};
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\RaceAppRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceAppRepository      $repository,
    )
    {}

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     * @throws Exception
     */
    public function import(SymfonyStyle $io, string $directory): void
    {
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return RaceApp
     */
    public function createEntity(array $datas): RaceApp
    {
        $entity = new RaceApp();
        $entity->setRaceOrder((int) $datas['RaceOrder']);
        $entity->setFinished(true);
        $entity->setMode($this->entityManager->getRepository(RaceMode::class)->findOneBy(['name' => $datas['Mode']]));
        $entity->setSeason($this->entityManager->getRepository(RaceSeason::class)->findOneBy(['name' => $datas['Season']]));
        $entity->setTime($this->entityManager->getRepository(RaceTime::class)->findOneBy(['name' => $datas['Time']]));
        $entity->setTrack($this->entityManager->getRepository(RaceTrack::class)->findOneBy(['nameEnglish' => $datas['English']]));

        return $entity;
    }

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return 'races';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.race.app');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.app');
    }
}
