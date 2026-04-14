<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Garage;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\GarageUpgrade;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\GarageUpgradeRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageUpgradeCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface  $entityManager,
        private readonly LoggerInterface         $logger,
        private readonly ParameterBagInterface   $parameter,
        private readonly GarageUpgradeRepository $repository,
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
     * @return GarageUpgrade
     */
    public function createEntity(array $datas): GarageUpgrade
    {
        $garage = $this->findGarage($datas);
        $entity = new GarageUpgrade();
        $entity->setSpeed((int) $datas['Speed']);
        $entity->setAcceleration((int) $datas['Acceleration']);
        $entity->setHandling((int) $datas['Handling']);
        $entity->setNitro((int) $datas['Nitro']);
        $entity->setCommon((int) $datas["Common"]);
        $entity->setRare((int) $datas["Rare"]);
        $entity->setEpic((int) $datas["Epic"]);
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
        return $this->parameter->get('csv.file.garage.upgrade');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.upgrade');
    }
}
