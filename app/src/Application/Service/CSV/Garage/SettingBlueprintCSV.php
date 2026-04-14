<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Garage;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBlueprint;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\GarageAppRepository;
use App\Infrastructure\Datas\CSV;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingBlueprintCSV implements CSVInterface
{
    use MigrationCSV;

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
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
        ### Init Variable
        $datas = [];

        ### Get Datas from Database
        $rows = $this->repository->findAll();

        ### Handler
        foreach ($rows as $row) {
            $datas[] = [
                $row->getSettingBrand()->getName(),
                $row->getModel(),
                $row->getSettingBlueprint()->getSlug(),
            ];
        }

        ### Get FolderPath
        $path = Folder::makeDirectory($directory, $this->getFolder(), true);

        ### Get FilePath
        $csv = Folder::normalize($path . $this->getFile());

        ### Make File
        try {
            CSV::ArrayToFile($csv, $this->getHeader(), $datas);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la création du CSV');
            $this->logger->error($e->getMessage());
            $this->logger->error('CSV : ' . $csv);
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
     * @return string
     */
    public function getFolder(): string
    {
        return 'garages';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.garage.setting.blueprint');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.setting.blueprint');
    }
}
