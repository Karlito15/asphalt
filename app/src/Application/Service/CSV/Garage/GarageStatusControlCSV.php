<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Garage;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\GarageStatusControl;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\GarageStatusControlRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatusControlCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface        $entityManager,
        private readonly LoggerInterface               $logger,
        private readonly ParameterBagInterface         $parameter,
        private readonly GarageStatusControlRepository $repository,
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
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageStatusControl
     */
    public function createEntity(array $datas): GarageStatusControl
    {
        $garage = $this->findGarage($datas);
        $entity = new GarageStatusControl();
        $entity->setGarage($garage);

        return $entity;
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
        return $this->parameter->get('csv.file.garage.status-control');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.status-control');
    }
}
