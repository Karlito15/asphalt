<?php

namespace App\Able;

use Symfony\Contracts\Translation\TranslatorInterface;

trait FormAble
{
    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }
}
