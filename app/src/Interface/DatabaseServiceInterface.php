<?php

declare(strict_types=1);

namespace App\Interface;

use Symfony\Component\Console\Style\SymfonyStyle;

interface DatabaseServiceInterface
{
    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function import(SymfonyStyle $io): bool;

    /**
     * @param SymfonyStyle $io
     * @return void
     */
    public function export(SymfonyStyle $io): void;

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
