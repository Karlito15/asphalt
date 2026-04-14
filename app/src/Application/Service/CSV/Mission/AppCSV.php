<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Mission;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\MissionApp;
use App\Domain\Entity\MissionTask;
use App\Domain\Entity\MissionType;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\MissionAppRepository;
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
        private readonly MissionAppRepository   $repository,
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
     * @return MissionApp
     */
    public function createEntity(array $datas): MissionApp
    {
        $entity = new MissionApp();
        $entity->setWeek((int) $datas['Week']);
        $entity->setRegion(($datas['Region'] != "") ? (string) $datas['Region'] : NULL);
        $entity->setTrack(($datas['Track'] != "") ? (string) $datas['Track'] : NULL);
        $entity->setClass(($datas['Class'] != "") ? (string) $datas['Class'] : NULL);
        $entity->setBrand(($datas['Brand'] != "") ? (string) $datas['Brand'] : NULL);
        $entity->setDescription(($datas['Description'] != "") ? (string) $datas['Description'] : NULL);
        $entity->setSuccess((int) $datas['Success']);
        $entity->setTarget((int) $datas['Target']);
        $entity->setTask($this->entityManager->getRepository(MissionTask::class)->findOneBy(['value' => $datas['Task']]));
        $entity->setType($this->entityManager->getRepository(MissionType::class)->findOneBy(['value' => $datas['Type']]));

        return $entity;
    }

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return 'missions';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.mission.app');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.mission.app');
    }
}
