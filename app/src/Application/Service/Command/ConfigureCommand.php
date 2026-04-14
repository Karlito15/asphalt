<?php

declare(strict_types=1);

namespace App\Application\Service\Command;

trait ConfigureCommand
{
    /**
     * Configure your CLI Application
     */
    protected function configure(): void
    {
        // Set methods
        $this->setAliases($this->getAliases());
        $this->setDescription($this->getDescription());
        $this->setHelp(static::$help);
        $this->setHidden($this->isHidden());
        $this->setName($this->getName());
        $this->setProcessTitle(static::$title);
    }
}
