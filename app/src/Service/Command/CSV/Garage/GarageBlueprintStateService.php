<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageBlueprintState;
use App\Persistence\Repository\GarageBlueprintStateRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageBlueprintStateService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'garage-blueprint-state.csv';

    public function __construct(
        private readonly EntityManagerInterface         $entityManager,
        private readonly LoggerInterface                $logger,
        private readonly ParameterBagInterface          $parameter,
        private readonly GarageBlueprintStateRepository $repository,
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
        $io->text('From CSV : Garage Blueprint State');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Blueprint State');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageBlueprintState
     */
    public function createEntity(array $datas): GarageBlueprintState
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);

        $entity = new GarageBlueprintState();
        $entity->setGarage($garage);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.blueprint.state');
    }
}
