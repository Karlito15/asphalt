<?php

declare(strict_types=1);

namespace App\Application\Service\Command\Database\Setting;

use App\Application\Service\Command\MigrationService;
use App\Infrastructure\Persistence\Entity\SettingBlueprint;
use App\Infrastructure\Persistence\Repository\SettingBlueprintRepository;
use App\Interface\DatabaseServiceInterface;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BlueprintService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'settings';

    private static string $file = 'blueprint.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingBlueprintRepository $repository,
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
        $io->text('From CSV : Setting Blueprint');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Setting Blueprint');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return SettingBlueprint
     */
    public function createEntity(array $datas): SettingBlueprint
    {
        $entity = new SettingBlueprint();
        $entity
            ->setStar1((string) $datas['Star1'])
            ->setStar2((int) $datas['Star2'])
            ->setStar3((int) $datas['Star3'])
            ->setStar4((int) $datas['Star4'])
            ->setStar5((int) $datas['Star5'])
            ->setStar6((int) $datas['Star6'])
        ;

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.blueprint');
    }
}
