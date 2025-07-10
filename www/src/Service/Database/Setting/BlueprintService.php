<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\SettingBlueprint;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\SettingBlueprintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BlueprintService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;

    private static string $folder = 'settings';

    private static string $file = 'blueprint.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingBlueprintRepository $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Blueprint');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Blueprint');
        $this->makeAnExport();
    }

    /**
     * @param array $datas
     * @return SettingBlueprint
     */
    public function createEntity(array $datas): SettingBlueprint
    {
        $entity = new SettingBlueprint();
        $entity
            ->setStar1($datas['Star1'])
            ->setStar2((int) $datas['Star2'])
            ->setStar3((int) $datas['Star3'])
            ->setStar4((int) $datas['Star4'])
            ->setStar5((int) $datas['Star5'])
            ->setStar6((int) $datas['Star6'])
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return ['Star1', 'Star2', 'Star3', 'Star4', 'Star5', 'Star6', 'Total', 'Slug'];
    }
}
