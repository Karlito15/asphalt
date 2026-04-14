<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Setting;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\SettingTag;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\SettingTagRepository;
use App\Infrastructure\System\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TagCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingTagRepository $repository,
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

    public function createEntity(array $datas): SettingTag
    {
        $entity = new SettingTag();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    public function getFolder(): string
    {
        return 'settings';
    }

    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.setting.tag');
    }

    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.tag');
    }
}
