<?php

declare(strict_types=1);

namespace App\Service\Command\Database\Setting;

use App\Persistence\Entity\SettingTag;
use App\Persistence\Repository\SettingTagRepository;
use App\Interface\DatabaseServiceInterface;
use App\Service\Command\MigrationService;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TagService implements DatabaseServiceInterface
{
    use MigrationService;

    private static string $folder = 'settings';

    private static string $file = 'tag.csv';

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface        $logger,
        private readonly ParameterBagInterface  $parameter,
        private readonly SettingTagRepository   $repository,
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
        $io->text('From CSV : Setting Tag');
        $this->makeAnImport($io, $directory . self::$folder . DIRECTORY_SEPARATOR . self::$file);
    }

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void
    {
        $io->text('From Database : Setting Tag');
        $this->makeAnExport($directory);
    }

    /**
     * @param array $datas
     * @return SettingTag
     */
    public function createEntity(array $datas): SettingTag
    {
        $entity = new SettingTag();
        $entity->setValue($datas['Value']);

        return $entity;
    }

    /**
     * @return string[]
     */
    public function getHeader(): array
    {
        return $this->parameter->get('csv.header.setting.tag');
    }
}
