<?php

declare(strict_types=1);

namespace App\Service\Database\Setting;

use App\Entity\SettingUnitPrice;
use App\Interface\DatabaseServiceInterface;
use App\Repository\SettingUnitPriceRepository;
use App\Trait\Service\Database\ExportTrait;
use App\Trait\Service\Database\ImportTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UnitPriceService implements DatabaseServiceInterface
{
    use ExportTrait;
    use ImportTrait;

    private static string $folder = 'settings';

    private static string $file = 'unit-price.csv';

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingUnitPriceRepository $repository,
    ) {}

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool
    {
        $io->text('From CSV : Setting Unit Price');

        return $this->makeAnImport($io);
    }

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void
    {
        $io->text('From Database : Setting Unit Price');
        $this->makeAnExport();
    }

    /**
     * @param array $datas
     * @return SettingUnitPrice
     */
    public function createEntity(array $datas): SettingUnitPrice
    {
        $entity = new SettingUnitPrice();
        $entity
            ->setLevel01((int) $datas['Level01'])
            ->setLevel02((int) $datas['Level02'])
            ->setLevel03((int) $datas['Level03'])
            ->setLevel04((int) $datas['Level04'])
            ->setLevel05((int) $datas['Level05'])
            ->setLevel06((int) $datas['Level06'])
            ->setLevel07((int) $datas['Level07'])
            ->setLevel08((int) $datas['Level08'])
            ->setLevel09((int) $datas['Level09'])
            ->setLevel10((int) $datas['Level10'])
            ->setCommon((int) $datas['Common'])
            ->setRare((int) $datas['Rare'])
        ;
        ($datas['Level11'] === '\0' OR $datas['Level11'] === '') ? $entity->setLevel11(null) : $entity->setLevel11((int) $datas['Level11']);
        ($datas['Level12'] === '\0' OR $datas['Level12'] === '') ? $entity->setLevel12(null) : $entity->setLevel12((int) $datas['Level12']);
        ($datas['Level13'] === '\0' OR $datas['Level13'] === '') ? $entity->setLevel13(null) : $entity->setLevel13((int) $datas['Level13']);
        ($datas['Epic'] === '\0' OR $datas['Epic'] === '') ? $entity->setEpic(null) : $entity->setEpic((int) $datas['Epic']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return [
            'Level01', 'Level02', 'Level03', 'Level04', 'Level05', 'Level06', 'Level07', 'Level08',
            'Level09', 'Level10', 'Level11', 'Level12', 'Level13', 'Common', 'Rare', 'Epic', 'Slug'
        ];
    }
}
