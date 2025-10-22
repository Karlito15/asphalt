<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Entity\SettingTag;
use App\Interface\DatabaseServiceInterface;
use App\Repository\SettingTagRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TagService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'settings';

    private static string $file = 'tag.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingTagRepository   $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Tag');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Tag');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): SettingTag
    {
        $entity = new SettingTag();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Value', 'Number', 'Slug'];
    }
}
