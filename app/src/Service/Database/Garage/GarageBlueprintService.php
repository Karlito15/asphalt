<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Entity\GarageBlueprint;
use App\Interface\DatabaseServiceInterface;
use App\Repository\GarageBlueprintRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\GarageServiceTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageBlueprintService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;
    use GarageServiceTrait;

    private static string $folder = 'garages';

    private static string $file = 'garage-blueprint.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageBlueprintRepository  $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Blueprint');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Blueprint');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageBlueprint
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);

        $entity = new GarageBlueprint();
        $entity->setStar1($datas['Star1']);
        $entity->setStar2($this->convertStringToInteger($datas['Star2']));
        $entity->setStar3($this->convertStringToInteger($datas['Star3']));
        $entity->setStar4($this->convertStringToInteger($datas['Star4']));
        $entity->setStar5($this->convertStringToInteger($datas['Star5']));
        $entity->setStar6($this->convertStringToInteger($datas['Star6']));
        $entity->setGarage($garage);

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Star1', 'Star2', 'Star3', 'Star4', 'Star5', 'Star6', 'Brand', 'Model'];
    }
}
