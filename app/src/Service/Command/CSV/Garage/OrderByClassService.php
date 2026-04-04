<?php

declare(strict_types=1);

namespace App\Service\Command\CSV\Garage;

use App\Persistence\Entity\SettingClass;
use App\Persistence\Repository\GarageAppRepository;
use App\Toolbox\File\CSV;
use App\Toolbox\System\Path;
use App\Toolbox\Trait\Command\MigrationCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OrderByClassService
{
    use MigrationCommand;

    private static string $folder  = 'car-by-class';

    private static string $file    = 'class-%s.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageAppRepository    $repository,
    )
    {}

    public function export(): void
    {
        ### Folder
        $folder = Path::canonicalize($this->parameter->get('folders.csv.order') . self::$folder) . DIRECTORY_SEPARATOR;

        foreach (['D', 'C', 'B', 'A', 'S'] as $class) {
            ### Variables
            $result = [];

            ### Find Setting Class
            $setting = $this->entityManager->getRepository(SettingClass::class)->findByClass($class);

            ### Find Garage
            $garage = $this->repository->findBy(['settingClass' => $setting], ['carOrder' => 'ASC']);

            ### Process
            foreach ($garage as $item) {
                $result[] = [$item->getSettingBrand()->getName(), $item->getModel(), $item->getCarOrder()];
            }

            ### Rename File
            $filepath = sprintf(self::$file, $class);

            ### Generate CSV
            CSV::ArrayToFile($folder . $filepath, $this->getHeader(), $result);
        }
    }

    /**
     * @throws \JsonException
     */
    public function import(): void
    {
        ### Folder
        $folder = Path::canonicalize($this->parameter->get('folders.csv.order') . self::$folder) . DIRECTORY_SEPARATOR;

        foreach (['D', 'C', 'B', 'A', 'S'] as $class) {
            ### Get File
            $filepath = $folder . sprintf(self::$file, $class);

            ### Get Datas
            $datas = CSV::FileToArray($filepath);

            ### Update Entity
            foreach ($datas as $data) {
                $garage = $this->findGarage($data);
                $garage->setCarOrder($this->convertStringToInteger($data['Order']));
            }

            ### Flush Datas
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }

    /**
     * @return string[]
     */
    private function getHeader(): array
    {
        return $this->parameter->get('csv.header.order.class');
    }
}
