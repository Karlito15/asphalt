<?php

declare(strict_types=1);

namespace App\Trait\Service\File;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

trait DirectoryTrait
{
    /**
     * @param string $file
     * @param string|null $folder
     * @return string
     */
    private function getCSVFile(string $file, string|null $folder = null): string
    {
        $filesystem  = new Filesystem();
        $environment = $this->parameter->get('kernel.environment');
        $csv_dir     = $this->getCSVDir();

        /** folder */
        $folderpath = (is_null($folder)) ? null : $folder . DIRECTORY_SEPARATOR;
        $path       = Path::normalize($csv_dir . $folderpath);
        $check      = $filesystem->exists($path);
        if (false === $check) {
            $filesystem->mkdir($path);
        }

        /** file */
        $csv_file   = (($environment === 'dev') ? 'dev---' . $file : $file);
        $filepath   = (is_null($folder)) ? $csv_file : $folder . DIRECTORY_SEPARATOR . $csv_file;

        return Path::normalize($csv_dir . $filepath);
    }

    /**
     * @return string
     */
    private function getDocumentDir(): string
    {
        $project_dir  = $this->parameter->get('kernel.project_dir');
        $document_dir = dirname($project_dir);

        return Path::normalize($document_dir. DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR);
    }

    /**
     * @return string
     */
    private function getCSVDir(): string
    {
        return Path::normalize($this->getDocumentDir() . 'csv' . DIRECTORY_SEPARATOR);
    }

    /**
     * @return string
     */
    private function getYAMLDir(): string
    {
        return Path::normalize($this->getDocumentDir() . 'yaml' . DIRECTORY_SEPARATOR);
    }
}
