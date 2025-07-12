<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\GarageServiceAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\GarageRank;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\GarageRankRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageRankService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;
    use GarageServiceAble;

    private static string $folder = 'garages';

    private static string $file = 'garage-rank.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageRankRepository       $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Garage Rank');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Garage Rank');
        $this->makeAnExport();
    }

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

    public function getHeader(): array
    {
        return ['Star0', 'Star1', 'Star2', 'Star3', 'Star4', 'Star5', 'Star6', 'Brand', 'Model'];
    }
}
