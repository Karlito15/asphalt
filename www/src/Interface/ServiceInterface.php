<?php

namespace App\Interface;

use Symfony\Component\Console\Style\SymfonyStyle;

interface ServiceInterface
{
    public function import(SymfonyStyle $io): bool;

    public function export(SymfonyStyle $io): void;

    public function createEntity(array $datas);

    public function getCSVFile(): string;
}
