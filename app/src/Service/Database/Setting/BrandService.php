<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Entity\SettingBrand;
use App\Interface\DatabaseServiceInterface;
use App\Repository\SettingBrandRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrandService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'settings';

    private static string $file = 'brand.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingBrandRepository $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Brand');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Brand');
        $this->makeAnExport();
    }

    /**
     * @param array $datas
     * @return SettingBrand
     */
    public function createEntity(array $datas): SettingBrand
    {
        $entity = new SettingBrand();
        $entity
            ->setName($datas['Name'])
            ->setCarsNumber((int) $datas['Number'])
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return ['Name', 'Number', 'Slug'];
    }
}
