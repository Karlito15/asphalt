<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;
use App\Persistence\Repository\GarageAppRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageAppService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'garages';

    private static string $file = 'app.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageAppRepository    $repository,
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
        $io->text('From CSV : Garage App');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage App');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageApp
     */
    public function createEntity(array $datas): GarageApp
    {
        $entity = new GarageApp();
        $entity->setStars((int) $datas['Stars']);
        $entity->setGameUpdate((int) $datas['GameUpdate']);
        $entity->setCarOrder((int) $datas['CarOrder']);
        $entity->setStatOrder((int) $datas['StatOrder']);
        $entity->setModel((string) $datas['Model']);
        $entity->setLevel((int) $datas['Level']);
        $entity->setEpic((int) $datas['Epic']);
        // Relation
        if (is_null($datas['Brand']) === false) {
            $brand = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $datas['Brand']]);
            $entity->setSettingBrand($brand);
        }
        if (is_null($datas['SettingClassValue']) === false) {
            $class = $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $datas['SettingClassValue']]);
            $entity->setSettingClass($class);
        }

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.app');
    }
}
