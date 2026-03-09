<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageUpgrade;
use App\Persistence\Repository\GarageUpgradeRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageUpgradeService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'garage-upgrade.csv';

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
        $io->text('From CSV : Garage Upgrade');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Upgrade');
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
        $entity->setSpeed($this->convertStringToInteger($datas['Speed']));
        $entity->setAcceleration($this->convertStringToInteger($datas['Acceleration']));
        $entity->setHandling($this->convertStringToInteger($datas['Handling']));
        $entity->setNitro($this->convertStringToInteger($datas['Nitro']));
        $entity->setCommon($this->convertStringToInteger($datas["Common"]));
        $entity->setRare($this->convertStringToInteger($datas["Rare"]));
        $entity->setEpic($this->convertStringToInteger($datas["Epic"]));
        $entity->setGarage($garage);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.upgrade');
    }
}
