<?php

declare(strict_types=1);

namespace App\Service\Database\Race;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\RaceRegion;
use App\Entity\RaceTrack;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\RaceTrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TrackService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'races';

    private static string $file = 'track.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly RaceTrackRepository        $repository,
    )
    {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Race Track');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Race Track');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): RaceTrack
    {
        $entity = new RaceTrack();
        $entity->setNameEnglish((string) $datas['English']);
        if (!is_null($datas['French'])) {
            $entity->setNameFrench($datas['French']);
        }
        $entity->setRegion($this->entityManager->getRepository(RaceRegion::class)->findOneBy(['name' => $datas['Region']]));

        return $entity;
    }

    public function getHeader(): array
    {
        return ['English', 'French', 'Slug', 'Region'];
    }
}
