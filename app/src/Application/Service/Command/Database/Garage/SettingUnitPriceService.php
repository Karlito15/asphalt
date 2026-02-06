<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Garage;

use App\Application\Service\Command\MigrationService;
use App\Application\Service\Command\PathService;
use App\Infrastructure\Persistence\Entity\GarageApp;
use App\Infrastructure\Persistence\Entity\SettingUnitPrice;
use App\Infrastructure\Persistence\Repository\GarageAppRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use KarlitoWeb\Toolbox\File\CSV;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingUnitPriceService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'garages';

    private static string $file = 'setting-price.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageAppRepository    $repository,
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
        $io->text('From CSV : Garage Setting UnitPrice');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Setting UnitPrice');

        /* Custom Export */

        // Get Datas from Database
        $rows = $this->repository->findAll();

        // Init Variable
        $datas = [];

        //
        foreach ($rows as $row) {
            $datas[] = [
                $row->getSettingBrand()->getName(),
                $row->getModel(),
                $row->getSettingUnitPrice()->getSlug(),
            ];
        }

        // Get FolderPath
        $path = PathService::makeDirectory($directory, self::$folder);

        // Get FilerPath
        $csv = $path . DIRECTORY_SEPARATOR . self::$file;

        // Make File
        try {
            CSV::ArrayToFile($csv, $this->getHeader(), $datas);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création du CSV');
            $this->logger->error($e->getMessage());
            $this->logger->error('Class : ' . __CLASS__);
            $this->logger->error('CSV   : ' . $csv);
        }
    }

    /**
     * @param array $datas
     * @return GarageApp
     */
    public function createEntity(array $datas): GarageApp
    {
        $priceUnit  = $this->entityManager->getRepository(SettingUnitPrice::class)->findOneBy(['slug' => $datas['SettingPrice']]);
        $garage     = $this->findGarage($datas['Brand'], $datas['Model']);
        $garage->setSettingUnitPrice($priceUnit);

        return $garage;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.setting.unit-price');
    }
}
