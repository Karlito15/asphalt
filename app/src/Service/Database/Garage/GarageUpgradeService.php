<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Entity\GarageUpgrade;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageUpgradeRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageUpgradeService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'garage-upgrade.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageUpgradeRepository    $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Upgrade');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Upgrade');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageUpgrade
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
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

    public function getHeader(): array
    {
        return ['Speed', 'Acceleration', 'Handling', 'Nitro', 'Common', 'Rare', 'Epic', 'Brand', 'Model'];
    }
}
