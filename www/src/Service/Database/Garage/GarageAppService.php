<?php

declare(strict_types=1);

namespace App\Service\Database\Garage;

use App\Able\Service\Database\ExportAble;
use App\Able\Service\Database\GarageServiceAble;
use App\Able\Service\Database\ImportAble;
use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Interface\ServiceDatabaseInterface;
use App\Repository\GarageAppRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GarageAppService implements ServiceDatabaseInterface
{
    use ExportAble;
    use ImportAble;
    use GarageServiceAble;

    private static string $folder = 'garages';

    private static string $file = 'app.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly GarageAppRepository        $repository,
    ) {}

    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : App Garage');
        return $this->makeAnImport($io);
    }

    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : App Garage');
        $this->makeAnExport();
    }

    public function createEntity(array $datas): GarageApp
    {
        $unlocked = ($datas['Locked'] == '0') ? 1 : 0;
        $entity = new GarageApp();
        $entity->setStars((int) $datas['Stars']);
        $entity->setGameUpdate((int) $datas['GameUpdate']);
        $entity->setCarOrder((int) $datas['CarOrder']);
        $entity->setStatOrder((int) $datas['StatOrder']);
        $entity->setModel((string) $datas['Model']);
        $entity->setLevel((int) $datas['Level']);
        $entity->setEpic((int) $datas['Epic']);
        $entity->setUnlocked((bool) $unlocked);
        $entity->setGold((bool) $datas['Gold']);
        // Add Setting Brand
        if (is_null($datas['Brand']) === false) {
            $brand = $this->entityManager->getRepository(SettingBrand::class)->findOneBy(['name' => $datas['Brand']]);
            $entity->setSettingBrand($brand);
        }
        // Add Setting Class
        if (is_null($datas['SettingClassValue']) === false) {
            $class = $this->entityManager->getRepository(SettingClass::class)->findOneBy(['value' => $datas['SettingClassValue']]);
            $entity->setSettingClass($class);
        }

        return $entity;
    }

    public function getHeader(): array
    {
        return ['Brand', 'Model', 'Stars', 'GameUpdate', 'CarOrder', 'StatOrder', 'Level', 'Epic', 'Locked', 'Gold', 'SettingClassValue'];
    }
}
