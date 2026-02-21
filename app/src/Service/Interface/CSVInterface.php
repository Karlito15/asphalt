<?php

declare(strict_types=1);

namespace App\Service\Interface;

use Symfony\Component\Console\Style\SymfonyStyle;

interface CSVInterface
{
    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function import(SymfonyStyle $io, string $directory): void;

    /**
     * @param SymfonyStyle $io
     * @param string $directory
     * @return void
     */
    public function export(SymfonyStyle $io, string $directory): void;

    /**
     * @param array $datas
     * @return mixed
     */
    public function createEntity(array $datas): mixed;

    /**
     * @return array
     */
    public function getHeader(): array;
}
