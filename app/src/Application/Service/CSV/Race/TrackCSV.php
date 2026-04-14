<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Race;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\{RaceRegion, RaceTrack};
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\RaceTrackRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TrackCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceTrackRepository    $repository,
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
     * @return RaceTrack
     */
    public function createEntity(array $datas): RaceTrack
    {
        $entity = new RaceTrack();
        $entity->setNameEnglish((string) $datas['English']);
        if (is_null($datas['French']) or $datas['French'] === '') {
            $entity->setNameFrench(null);
        } else {
            $entity->setNameFrench($datas['French']);
        }
        $entity->setRegion($this->entityManager->getRepository(RaceRegion::class)->findOneBy(['name' => $datas['Region']]));

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
        return $this->parameter->get('csv.file.race.track');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.track');
    }
}
