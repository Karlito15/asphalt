<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Setting;

use App\Persistence\Entity\SettingBlueprint;
use App\Persistence\Repository\SettingBlueprintRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BlueprintService implements CSVInterface
{
    use MigrationCommand;

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
            ->setStar2($this->convertStringToInteger($datas['Star2']))
            ->setStar3($this->convertStringToInteger($datas['Star3']))
            ->setStar4($this->convertStringToInteger($datas['Star4']))
            ->setStar5($this->convertStringToInteger($datas['Star5']))
            ->setStar6($this->convertStringToInteger($datas['Star6']))
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
