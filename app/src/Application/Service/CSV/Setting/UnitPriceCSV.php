<?php

declare(strict_types=1);

namespace App\Application\Service\CSV\Setting;

use App\Application\Service\CSV\MigrationCSV;
use App\Domain\Entity\SettingUnitPrice;
use App\Domain\Interface\CSVInterface;
use App\Domain\Repository\SettingUnitPriceRepository;
use App\Infrastructure\System\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UnitPriceCSV implements CSVInterface
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface     $entityManager,
        private readonly LoggerInterface            $logger,
        private readonly ParameterBagInterface      $parameter,
        private readonly SettingUnitPriceRepository $repository,
    )
    {}

    public function import(SymfonyStyle $io, string $directory): void
    {
        $filepath = Folder::normalize($directory . $this->getFolder() . DIRECTORY_SEPARATOR . $this->getFile());
        $this->makeAnImport($io, $filepath);
    }

    public function export(SymfonyStyle $io, string $directory): void
    {
        $this->makeAnExport($directory);
    }

    public function createEntity(array $datas): SettingUnitPrice
    {
        $entity = new SettingUnitPrice();
        $entity->setLevel01((int) $datas['Level01']);
        $entity->setLevel02((int) $datas['Level02']);
        $entity->setLevel03((int) $datas['Level03']);
        $entity->setLevel04((int) $datas['Level04']);
        $entity->setLevel05((int) $datas['Level05']);
        $entity->setLevel06((int) $datas['Level06']);
        $entity->setLevel07((int) $datas['Level07']);
        $entity->setLevel08((int) $datas['Level08']);
        $entity->setLevel09((int) $datas['Level09']);
        $entity->setLevel10((int) $datas['Level10']);
        $entity->setCommon((int) $datas['Common']);
        $entity->setRare((int) $datas['Rare']);
        ($datas['Level11'] === '\0' OR $datas['Level11'] === '') ? $entity->setLevel11(null) : $entity->setLevel11((int) $datas['Level11']);
        ($datas['Level12'] === '\0' OR $datas['Level12'] === '') ? $entity->setLevel12(null) : $entity->setLevel12((int) $datas['Level12']);
        ($datas['Level13'] === '\0' OR $datas['Level13'] === '') ? $entity->setLevel13(null) : $entity->setLevel13((int) $datas['Level13']);
        ($datas['Epic']    === '\0' OR $datas['Epic']    === '') ? $entity->setEpic(null) : $entity->setEpic((int) $datas['Epic']);

        return $entity;
    }

    public function getFolder(): string
    {
        return 'settings';
    }

    public function getFile(): array|string
    {
        return $this->parameter->get('csv.file.setting.unit-price');
    }

    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.unit-price');
    }
}
