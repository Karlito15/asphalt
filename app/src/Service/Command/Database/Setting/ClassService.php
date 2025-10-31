<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Setting;

use App\Entity\SettingClass;
use App\Interface\DatabaseServiceInterface;
use App\Repository\SettingClassRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ClassService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'database' . DIRECTORY_SEPARATOR . 'settings';

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
