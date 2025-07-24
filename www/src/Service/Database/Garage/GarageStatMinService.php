<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\GarageServiceAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\GarageStatMin;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\GarageStatMinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatMinService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;
    use GarageServiceAble;

    private static string $folder = 'garages';

    private static string $file = 'garage-stat-min.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageStatMinRepository    $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Stat Min');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Stat Min');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageStatMin
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageStatMin();
        $entity->setSpeed((float) $datas['Speed']);
        $entity->setAcceleration((float) $datas['Acceleration']);
        $entity->setHandling((float) $datas['Handling']);
        $entity->setNitro((float) $datas['Nitro']);
        $entity->setGarage($garage);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Speed', 'Acceleration', 'Handling', 'Nitro', 'Average', 'Brand', 'Model'];
    }
}
