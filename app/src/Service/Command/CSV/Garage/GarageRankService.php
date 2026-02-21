<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageRank;
use App\Persistence\Repository\GarageRankRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageRankService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'garage-rank.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageRankRepository   $repository,
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
        $io->text('From CSV : Garage Rank');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Rank');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageRank
     */
    public function createEntity(array $datas): GarageRank
    {
        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
        $entity = new GarageRank();
        $entity->setStar0((int) $datas['Star0']);
        $entity->setStar1((int) $datas['Star1']);
        $entity->setStar2((int) $datas['Star2']);
        $entity->setStar3((int) $datas['Star3']);
        $entity->setStar4((int) $datas['Star4']);
        $entity->setStar5((int) $datas['Star5']);
        $entity->setStar6((int) $datas['Star6']);
        $entity->setGarage($garage);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.rank');
    }
}
