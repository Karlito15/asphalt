<?php

declare(strict_types=1);

namespace App\Able\Command;

trait ConfigureAble
{
    /**
     * Configure your CLI Application
     */
    protected function configure(): void
    {
        /** Config  */
        $this->setName($this->getName());
        $this->setDescription($this->getDescription());
        $this->setAliases($this->getAliases());
        $this->setHidden($this->isHidden());
        $this->setProcessTitle(self::$title);
        $this->setHelp(self::$help);
    }
}
