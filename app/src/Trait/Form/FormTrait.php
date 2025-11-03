<?php

declare(strict_types=1);

namespace App\Trait\Form;

trait FormTrait
{
    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return '';
    }

    /**
     * @param int $number
     * @return string
     */
    private function star(int $number = 1): string
    {
        $star = '<i class="fa-solid fa-star text-warning"></i>';

        return match ($number) {
            2 => $star . $star,
            3 => $star . $star . $star,
            4 => $star . $star . $star . $star,
            5 => $star . $star . $star . $star . $star,
            6 => $star . $star . $star . $star . $star . $star,
            default => $star,
        };
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
