<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Form;

trait DefaultType
{
    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }

    /**
     * @return array
     */
    private static function labelClass(): array
    {
        return [
            'class' => 'm-0 fw-light',
        ];
    }
}
