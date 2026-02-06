<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Garage;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\GarageApp;
use App\Infrastructure\Persistence\Entity\SettingBrand;
use App\Infrastructure\Persistence\Entity\SettingClass;
use App\Infrastructure\Persistence\Repository\GarageAppRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageAppService implements DatabaseServiceInterface
{
    use MigrationService;

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
