<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Garage;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\GarageRank;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\GarageRankRepository;
use App\Infrastructure\System\Folder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageRankCSV implements CSVInterface
{
    use MigrationCSV;

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
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageRank
     */
    public function createEntity(array $datas): GarageRank
    {
        $garage = $this->findGarage($datas);
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
     * @return string
     */
    public function getFolder(): string
    {
        return 'garages';
    }

    /**
     * @return array|string
     */
    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.garage.rank');
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.rank');
    }
}
