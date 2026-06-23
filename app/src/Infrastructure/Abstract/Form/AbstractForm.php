<?php

declare(strict_types=1);

namespace App\Infrastructure\Abstract\Form;

use Symfony\Component\Form\AbstractType;

abstract class AbstractForm extends AbstractType
{
    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }

    /**
     * @return array<string, string>
     */
    public static function labelClass(): array
    {
        return [
            'class' => 'm-0 fw-light',
        ];
    }

    /**
     * @return string
     */
    public static function attrClass(): string
    {
        return 'fw-bolder';
    }

    /**
     * @return array<string, string>
     */
    public static function attrLabel(): array
    {
        return [
            'class' => 'btn btn-outline-info',
        ];
    }

    /**
     * @param int $number
     * @return string
     */
    public static function star(int $number = 0): string
    {
        $star = '<i class="fa-solid fa-star small text-warning"></i>';

        return match ($number) {
            1 => $star,
            2 => $star . $star,
            3 => $star . $star . $star,
            4 => $star . $star . $star . $star,
            5 => $star . $star . $star . $star . $star,
            6 => $star . $star . $star . $star . $star . $star,
            default => '<i class="fa-regular fa-star small text-danger"></i>',
        };
    }
}
