<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Setting;

use App\Entity\SettingLevel;
use App\Interface\DatabaseServiceInterface;
use App\Repository\SettingLevelRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LevelService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR . 'settings';

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
