<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Setting;

use App\Persistence\Entity\SettingUnitPrice;
use App\Persistence\Repository\SettingUnitPriceRepository;
use App\Service\Interface\CSVInterface;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UnitPriceService implements CSVInterface
{
    use MigrationCommand;

    private static string $folder = 'settings';

    private static string $file = 'unit-price.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingUnitPriceRepository $repository,
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
        $io->text('From CSV : Setting Unit Price');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Setting Unit Price');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return SettingUnitPrice
     */
    public function createEntity(array $datas): SettingUnitPrice
    {
        $entity = new SettingUnitPrice();
        $entity
            ->setLevel01($this->convertStringToInteger($datas['Level01']))
            ->setLevel02($this->convertStringToInteger($datas['Level02']))
            ->setLevel03($this->convertStringToInteger($datas['Level03']))
            ->setLevel04($this->convertStringToInteger($datas['Level04']))
            ->setLevel05($this->convertStringToInteger($datas['Level05']))
            ->setLevel06($this->convertStringToInteger($datas['Level06']))
            ->setLevel07($this->convertStringToInteger($datas['Level07']))
            ->setLevel08($this->convertStringToInteger($datas['Level08']))
            ->setLevel09($this->convertStringToInteger($datas['Level09']))
            ->setLevel10($this->convertStringToInteger($datas['Level10']))
            ->setCommon($this->convertStringToInteger($datas['Common']))
            ->setRare($this->convertStringToInteger($datas['Rare']))
        ;
        ($datas['Level11'] === '\0' OR $datas['Level11'] === '') ? $entity->setLevel11(null) : $entity->setLevel11($this->convertStringToInteger($datas['Level11']));
        ($datas['Level12'] === '\0' OR $datas['Level12'] === '') ? $entity->setLevel12(null) : $entity->setLevel12($this->convertStringToInteger($datas['Level12']));
        ($datas['Level13'] === '\0' OR $datas['Level13'] === '') ? $entity->setLevel13(null) : $entity->setLevel13($this->convertStringToInteger($datas['Level13']));
        ($datas['Epic']    === '\0' OR $datas['Epic']    === '') ? $entity->setEpic(null) : $entity->setEpic($this->convertStringToInteger($datas['Epic']));

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.unit-price');
    }
}
