<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Garage;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\GarageUpgrade;
use App\Infrastructure\Persistence\Repository\GarageUpgradeRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageUpgradeService implements DatabaseServiceInterface
{
    use MigrationService;

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

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.upgrade');
    }
}
