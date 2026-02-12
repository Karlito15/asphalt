<?php

declare(strict_types=1);

namespace App\Interface;

interface ExtractorServiceInterface
{
    /**
     * @return string
     */
    public function makeDirectory(): string;

    /**
     * @return string
     */
    public function extractDatas(): string;

    public function makeFile(string $directory, array $datas): void;
}
