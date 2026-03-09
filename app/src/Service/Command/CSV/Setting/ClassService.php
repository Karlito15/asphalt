<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Setting;

use App\Persistence\Entity\SettingClass;
use App\Persistence\Repository\SettingClassRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClassService implements CSVInterface
{
    use MigrationCommand;

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
            ->setClassOrder($this->convertStringToInteger($datas['Order']))
            ->setCarsNumber($this->convertStringToInteger($datas['Number']))
            ->setMedian($this->convertStringToInteger($datas['Median']))
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
