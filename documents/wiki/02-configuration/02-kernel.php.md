# Kernel

Modify Kernel.php
-----------------
Add
````php
    public function getCacheDir(): string
    {
        return dirname($this->getProjectDir()) . '/caches/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return dirname($this->getProjectDir()) . '/logs';
    }
````

