<?php

declare(strict_types=1);

namespace App\Interface;

use Symfony\Component\Console\Style\SymfonyStyle;

interface ServiceDatabaseInterface
{
    public function import(SymfonyStyle $io): bool;

    public function export(SymfonyStyle $io): void;

    public function createEntity(array $datas);

    public function getHeader(): array;
}
