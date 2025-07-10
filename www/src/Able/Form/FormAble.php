<?php

declare(strict_types=1);

namespace App\Able\Form;

trait FormAble
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

        switch ($number):
            case 2:
                $return = $star . $star;
                break;
            case 3:
                $return = $star . $star . $star;
                break;
            case 4:
                $return = $star . $star . $star . $star;
                break;
            case 5:
                $return = $star . $star . $star . $star . $star;
                break;
            case 6:
                $return = $star . $star . $star . $star . $star . $star;
                break;
            default:
                $return = $star;
        endswitch;

        return $return;
    }
}
