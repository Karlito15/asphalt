<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Setting;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\SettingBlueprintRepository;
use App\Infrastructure\System\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BlueprintCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingBlueprintRepository $repository,
    )
    {}

    public function import(SymfonyStyle $io, string $directory): void
    {
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
        $this->makeAnExport($directory);
    }

    public function createEntity(array $datas): mixed
    {
        $entity = new SettingBlueprint();
        $entity->setStar1((string) $datas['Star1']);
        $entity->setStar2((int) $datas['Star2']);
        $entity->setStar3((int) $datas['Star3']);
        $entity->setStar4((int) $datas['Star4']);
        $entity->setStar5((int) $datas['Star5']);
        $entity->setStar6((int) $datas['Star6']);

        return $entity;
    }

    public function getFolder(): string
    {
        return 'settings';
    }

    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.setting.blueprint');
    }

    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.blueprint');
    }
}
