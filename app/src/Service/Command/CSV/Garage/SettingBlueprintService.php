<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Repository\GarageAppRepository;
use App\Service\Command\PathService;
use App\Service\Interface\CSVInterface;
use App\Toolbox\File\CSV;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingBlueprintService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'setting-blueprint.csv';

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
        $io->text('From CSV : Garage Setting Blueprint');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Setting Blueprint');

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
                $row->getSettingBlueprint()->getSlug(),
            ];
        }

        // Get FolderPath
        $path = PathService::makeDirectory($directory, self::$folder, true);

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
        $blueprint = $this->entityManager->getRepository(SettingBlueprint::class)->findOneBy(['slug' => $datas['SettingBlueprint']]);
        
        $garage    = $this->findGarage($datas);
        $garage->setSettingBlueprint($blueprint);

        return $garage;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.setting.blueprint');
    }
}
