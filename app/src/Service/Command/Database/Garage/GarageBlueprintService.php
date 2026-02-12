<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Garage;

use App\Interface\DatabaseServiceInterface;
use App\Persistence\Entity\GarageBlueprint;
use App\Persistence\Repository\GarageBlueprintRepository;
use App\Service\Command\MigrationService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageBlueprintService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'garages';

    private static string $file = 'garage-blueprint.csv';

    public function __construct(
        private readonly EntityManagerInterface    $entityManager,
        private readonly LoggerInterface           $logger,
        private readonly ParameterBagInterface     $parameter,
        private readonly GarageBlueprintRepository $repository,
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
        $io->text('From CSV : Garage Blueprint');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Blueprint');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageBlueprint
     */
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

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.blueprint');
    }
}
