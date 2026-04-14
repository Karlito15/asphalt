<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Race;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\RaceSeason;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\RaceSeasonRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SeasonCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly RaceSeasonRepository   $repository,
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
     * @return RaceSeason
     */
    public function createEntity(array $datas): RaceSeason
    {
        $entity = new RaceSeason();
        $entity->setChapter((int) $datas['Chapter']);
        $entity->setName((string) $datas['Name']);

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
        return $this->parameter->get('csv.file.race.season');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.race.season');
    }
}
