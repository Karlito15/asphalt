<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Entity\GarageApp;
use App\Entity\SettingLevel;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageAppRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingLevelService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'setting-level.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageAppRepository        $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Setting Level');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Setting Level');
        /** Get Datas from Database */
        $rows = $this->repository->findAll();
        $datas = [];
        foreach ($rows as $row) {
            $datas[] = [
                $row->getSettingBrand()->getName(),
                $row->getModel(),
                $row->getSettingLevel()->getSlug(),
            ];
        }

        /** Get Filepath */
        $csv = $this->getCSVFile(self::$file, self::$folder);

        /** Make File */
        self::writeFile($csv, $this->getHeader(), $datas);
    }

    public function createEntity(array $datas): GarageApp
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        // $str    = str_replace("'", null, $datas['SettingLevel']);
        $level  = $this->entityManager->getRepository(SettingLevel::class)->findOneBy(['slug' => $datas['SettingLevel']]);
        $garage->setSettingLevel($level);

        return $garage;
    }

    public function getHeader(): array
    {
        return ['Brand', 'Model', 'SettingLevel'];
    }
}
