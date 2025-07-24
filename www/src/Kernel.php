<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

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

    /**
     * Retourne le chemin du dossier "vars"
     *
     * @return string
     */
    private function getVarsDir(): string
    {
        return dirname($this->getProjectDir()) . DIRECTORY_SEPARATOR . 'vars' . DIRECTORY_SEPARATOR;
    }
}
