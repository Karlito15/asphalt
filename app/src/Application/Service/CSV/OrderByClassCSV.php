<?php

declare(strict_types=1);

namespace App\Application\Service\CSV;

use App\Domain\Entity\SettingClass;
use App\Domain\Repository\GarageAppRepository;
use App\Infrastructure\Datas\CSV;
use App\Infrastructure\System\Folder;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OrderByClassCSV
{
    use MigrationCSV;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly GarageAppRepository    $repository,
    )
    {}

    public function export(): void
    {
        ### Folder
        $folder = $this->getDirectory();

        ### Handler
        foreach (['D', 'C', 'B', 'A', 'S'] as $class) {
            ### Variables
            $result = [];

            ### Find Setting Class
            $setting = $this->entityManager->getRepository(SettingClass::class)->findByClass($class);

            ### Find Garage
            $garage = $this->repository->findBy(['settingClass' => $setting], ['carOrder' => 'ASC']);

            ### Process
            foreach ($garage as $item) {
                $result[] = [
                    $item->getSettingBrand()->getName(),
                    $item->getModel(),
                    $item->getCarOrder()
                ];
            }

            ### Rename File
            $filepath = $folder . sprintf($this->parameter->get('csv.file.order.class'), $class);

            ### Generate CSV
            CSV::ArrayToFile($filepath, $this->getHeader(), $result);
        }
    }

    public function import(): void
    {
        ### Folder
        $folder = $this->getDirectory();

        ### Handler
        foreach (['D', 'C', 'B', 'A', 'S'] as $class) {
            ### Get File
            $filepath = $folder . sprintf($this->parameter->get('csv.file.order.class'), $class);

            ### Get Datas
            $datas = CSV::FileToArray($filepath);

            ### Update Entity
            foreach ($datas as $data) {
                $garage = $this->findGarage($data);
                $garage->setCarOrder((int) $data['Order']);
            }

            ### Flush Datas
            $this->entityManager->flush();
            $this->entityManager->clear();
        }
    }

    /** PRIVATE METHODS */

    /**
     * @return string[]
     */
    private function getHeader(): array
    {
        return $this->parameter->get('csv.header.order.class');
    }

    /**
     * @return string
     */
    private function getDirectory(): string
    {
        return Folder::canonicalize($this->parameter->get('csv.folders.order')) . DIRECTORY_SEPARATOR;
    }
}
