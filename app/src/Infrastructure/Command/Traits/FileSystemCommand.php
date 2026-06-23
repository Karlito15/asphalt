<?php

namespace App\Infrastructure\Command\Traits;

trait FileSystemCommand
{
    /**
     * @return string
     */
    public function getFolder(): string
    {
        return static::$folderName;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->parameter->get(static::$file);
    }

    /**
     * @return array<string>
     */
    public function getHeader(): array
    {
        return $this->parameter->get(static::$header);
    }
}
