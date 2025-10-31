<?php

declare(strict_types=1);

namespace App\Trait\Command;

trait ConfigureTrait
{
    protected string $help = '(To DO)';

    /**
     * Configure your CLI Application
     */
    protected function configure(): void
    {
        // Config
        $this->setName($this->getName());
        $this->setDescription($this->getDescription());
        $this->setAliases($this->getAliases());
        $this->setHidden($this->isHidden());
        $this->setProcessTitle(self::$title);
        // $this->setHelp($this->help);
    }
}
