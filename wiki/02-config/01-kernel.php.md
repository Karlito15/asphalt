# Kernel.php


### Modify Kernel.php

Add
``` php

    public function getBuildDir(): string
    {
        return $this->getVarsDir() . 'builds' . DIRECTORY_SEPARATOR . $this->environment;
    }

    public function getCacheDir(): string
    {
        return $this->getVarsDir() . 'caches' . DIRECTORY_SEPARATOR . $this->environment;
    }

    public function getLogDir(): string
    {
        return $this->getVarsDir() . 'logs';
    }

    public function getShareDir(): ?string
    {
        return $this->getVarsDir() . 'shares';
    }

    private function getVarsDir(): string
    {
        return dirname($this->getProjectDir()) . DIRECTORY_SEPARATOR . 'vars' . DIRECTORY_SEPARATOR;
    }
```
