<?php

declare(strict_types=1);

namespace App\Service\Command;

use KarlitoWeb\Toolbox\File\YAML;
use KarlitoWeb\Toolbox\System\Path;

trait ExtractorService
{

    /**
     * @return string
     */
    public function makeDirectory(): string
    {
        try {
            $root = Path::canonicalize($this->parameter->get('folders.yaml.extractor')) . DIRECTORY_SEPARATOR;
            return PathService::makeDirectory($root, self::$folder);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return '';
    }

    public function makeFile(string $directory, array $datas): void
    {
        try {
            YAML::ArrayToFile($directory . self::$file, $datas);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}
