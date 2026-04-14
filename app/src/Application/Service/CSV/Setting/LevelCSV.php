<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Setting;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\SettingLevel;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\SettingLevelRepository;
use App\Infrastructure\System\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LevelCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingLevelRepository $repository,
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
        $entity = new SettingLevel();
        $entity->setLevel((int) $datas['Level']);
        $entity->setCommon((int) $datas['Common']);
        $entity->setRare((int) $datas['Rare']);
        $entity->setEpic((int) $datas['Epic']);

        return $entity;
    }

    public function getFolder(): string
    {
        return 'settings';
    }

    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.setting.level');
    }

    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.level');
    }
}
