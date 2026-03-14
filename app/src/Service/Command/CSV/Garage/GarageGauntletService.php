<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageGauntlet;
use App\Persistence\Repository\GarageGauntletRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageGauntletService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'garage-gauntlet.csv';

    public function __construct(
        private readonly EntityManagerInterface   $entityManager,
        private readonly LoggerInterface          $logger,
        private readonly ParameterBagInterface    $parameter,
        private readonly GarageGauntletRepository $repository,
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
        $io->text('From CSV : Garage Gauntlet');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Gauntlet');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageGauntlet
     */
    public function createEntity(array $datas): GarageGauntlet
    {
        $garage = $this->findGarage($datas);
        $entity = new GarageGauntlet();
        $entity->setSpeed($this->convertStringToInteger($datas['Speed']));
        $entity->setAcceleration($this->convertStringToInteger($datas['Acceleration']));
        $entity->setHandling($this->convertStringToInteger($datas['Handling']));
        $entity->setNitro($this->convertStringToInteger($datas['Nitro']));
//        $entity->setMark($this->convertStringToInteger($datas['Mark']));
        $entity->setDivision($this->convertStringToInteger($datas['Division']));
        $entity->setGarage($garage);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.gauntlet');
    }
}
