<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Mission;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\MissionApp;
use App\Infrastructure\Persistence\Entity\MissionTask;
use App\Infrastructure\Persistence\Entity\MissionType;
use App\Infrastructure\Persistence\Repository\MissionAppRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'missions';

    private static string $file = 'app.csv';

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
        $io->text('From CSV : Mission App');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Mission App');
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
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.mission.app');
    }
}
