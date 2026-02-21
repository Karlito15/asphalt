<?php

declare(strict_types=1);

namespace App\Service\Interface;

interface YAMLInterface
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
