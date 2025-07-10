<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\SettingLevel;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\SettingLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LevelService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'settings';

    private static string $file = 'level.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingLevelRepository $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Level');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Level');
        $this->makeAnExport();
    }

    /**
     * @param array $datas
     * @return SettingLevel
     */
    public function createEntity(array $datas): SettingLevel
    {
        $entity = new SettingLevel();
        $entity
            ->setLevel((int) $datas['Level'])
            ->setCommon((int) $datas['Common'])
            ->setRare((int) $datas['Rare'])
            ->setEpic((int) $datas['Epic'])
        ;

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Level', 'Common', 'Rare', 'Epic', 'Slug'];
    }
}
