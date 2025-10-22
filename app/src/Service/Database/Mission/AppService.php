<?php

declare(strict_types=1);

namespace App\Service\Database\Mission;

use App\Entity\MissionApp;
use App\Entity\MissionTask;
use App\Entity\MissionType;
use App\Interface\DatabaseServiceInterface;
use App\Repository\MissionAppRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AppService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'missions';

    private static string $file = 'app.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly MissionAppRepository       $repository,
    )
    {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : App Mission');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : App Mission');
        $this->makeAnExport();
    }

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

    public function getHeader(): array
    {
        return ['Week', 'Region', 'Track', 'Class', 'Brand', 'Description', 'Success', 'Target', 'Task', 'Type'];
    }
}
