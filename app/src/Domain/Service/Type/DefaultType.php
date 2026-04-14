<?php

declare(strict_types=1);

namespace App\Domain\Service\Type;

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
        // text-start fw-bolder m-0 px-3 py-0 form-control-sm
        // GarageBlueprintType
        // text-center fw-bolder form-control form-control-sm
        // GarageGauntletType
        // text-center fw-bolder form-control form-control-sm
        // GarageRankType
        // text-center fw-bolder form-control-plaintext form-control-sm
        // text-start fw-bolder m-0 px-3 py-0 form-control-sm
        // GarageStatActualType
        // text-center fw-bolder form-control-plaintext form-control-sm
        // GarageStatMaxType
        // text-center fw-bolder form-control-plaintext form-control-sm
        // GarageStatMinType
        // text-center fw-bolder form-control-plaintext form-control-sm
        // DashboardInventoryType
        // 'text-end fw-bolder form-control form-control-lg'
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
