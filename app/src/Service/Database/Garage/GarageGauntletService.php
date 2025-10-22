<?php

namespace App\Service\Database\Garage;

use App\Entity\GarageGauntlet;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageGauntletRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageGauntletService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'garage-gauntlet.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageGauntletRepository   $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Gauntlet');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Gauntlet');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageGauntlet
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);

        $entity = new GarageGauntlet();
        $entity->setSpeed($datas['Speed']);
        $entity->setAcceleration($datas['Acceleration']);
        $entity->setHandling($datas['Handling']);
        $entity->setNitro($datas['Nitro']);
        $entity->setCalculateMark($datas['CalculateMark']);
        $entity->setTempMark($datas['TempMark']);
        $entity->setFinalMark($datas['FinalMark']);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Speed', 'Acceleration', 'Handling', 'Nitro', 'CalculateMark', 'TempMark', 'FinalMark', 'Brand', 'Model'];
    }
}
