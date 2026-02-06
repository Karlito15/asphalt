<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Setting;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\SettingClass;
use App\Infrastructure\Persistence\Repository\SettingClassRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClassService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'settings';

    private static string $file = 'class.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingClassRepository $repository,
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
        $io->text('From CSV : Setting Class');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Setting Class');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return SettingClass
     */
    public function createEntity(array $datas): SettingClass
    {
        $entity = new SettingClass();
        $entity
            ->setLabel($datas['Label'])
            ->setValue($datas['Value'])
            ->setClassOrder((int) $datas['Order'])
            ->setCarsNumber((int) $datas['Number'])
            ->setMedian((int) $datas['Median'])
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.class');
    }
}
