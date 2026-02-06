<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Garage;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\GarageStatMin;
use App\Infrastructure\Persistence\Repository\GarageStatMinRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageStatMinService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'garages';

    private static string $file = 'garage-stat-min.csv';

    public function __construct(
        private readonly EntityManagerInterface  $entityManager,
        private readonly LoggerInterface         $logger,
        private readonly ParameterBagInterface   $parameter,
        private readonly GarageStatMinRepository $repository,
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
        $io->text('From CSV : Garage Stat Min');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Stat Min');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageStatMin
     */
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

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.stats');
    }
}
