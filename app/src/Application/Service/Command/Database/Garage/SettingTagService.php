<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Garage;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\GarageApp;
use App\Infrastructure\Persistence\Repository\GarageAppRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SettingTagService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'garages';

    private static string $file = 'setting-tag.csv';

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
        $io->text('From CSV : Garage Setting Tag');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Garage Setting Tag');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return GarageApp
     */
    public function createEntity(array $datas): GarageApp
    {
//        $level  = $this->entityManager->getRepository(SettingTag::class)->findOneBy(['slug' => $datas['SettingTag']]);
//        $garage = $this->findGarage($datas['Brand'], $datas['Model']);
//        $garage->setSettingLevel($level);

        return $this->findGarage($datas['Brand'], $datas['Model']);
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.garage.setting.tag');
    }
}
