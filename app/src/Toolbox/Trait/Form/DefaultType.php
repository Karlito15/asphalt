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

    /**
     * @return string
     */
    private static function attrClass(): string
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
}
