<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\SettingTag;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\SettingTagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TagService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

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
