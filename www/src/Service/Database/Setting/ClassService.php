<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\SettingClass;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\SettingClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClassService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'settings';

    private static string $file = 'class.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingClassRepository $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Class');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Class');
        $this->makeAnExport();
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
        return ['Label', 'Value', 'Order', 'Number', 'Median', 'Slug'];
    }
}
