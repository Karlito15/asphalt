<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Entity\GarageApp;
use App\Entity\SettingBlueprint;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageAppRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingBlueprintService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'setting-blueprint.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageAppRepository        $repository,
    )
    {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Setting Blueprint');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Setting Blueprint');

        /** Get Datas from Database */
        $rows = $this->repository->findAll();
        $datas = [];
        foreach ($rows as $row) {
            $datas[] = [
                $row->getSettingBrand()->getName(),
                $row->getModel(),
                $row->getSettingBlueprint()->getSlug(),
            ];
        }

        /** Get Filepath */
        $csv = $this->getCSVFile(self::$file, self::$folder);

        /** Make File */
        self::writeFile($csv, $this->getHeader(), $datas);
    }

    public function createEntity(array $datas): GarageApp
    {
        $garage    = $this->findGarage($datas['Brand'], $datas['Model']);
        // $str       = str_replace("'", null, $datas['SettingBlueprint']);
        $blueprint = $this->entityManager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $datas['SettingBlueprint']]);
        $garage->setSettingBlueprint($blueprint);

        return $garage;
    }

    public function getHeader(): array
    {
        return ['Brand', 'Model', 'SettingBlueprint'];
    }
}
