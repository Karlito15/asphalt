<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Setting;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\SettingLevel;
use App\Infrastructure\Persistence\Repository\SettingLevelRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LevelService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'settings';

    private static string $file = 'level.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingLevelRepository $repository,
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
        $io->text('From CSV : Setting Level');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Setting Level');
        $this->makeAnExport($directory);
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

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.level');
    }
}
