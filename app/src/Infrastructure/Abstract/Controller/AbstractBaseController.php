<?php

declare(strict_types=1);

namespace App\Infrastructure\Abstract\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractBaseController extends AbstractController
{
    /**
     * @param array $datas
     * @return array
     */
    protected static function breadcrumb(array $datas = []): array
    {
        ### init variables
        $breadcrumb = [];

        foreach ($datas as $item) {
            $breadcrumb[] = [
                'label'  => $item['label'] ?? '',
                'route'  => $item['route'] ?? null,
                'params' => $item['params'] ?? [],
            ];
        }

        return $breadcrumb;
    }

//    /**
//     * Page 404
//     *
//     * @param bool $bool
//     * @return void
//     */
//    protected function return404(bool $bool): void
//    {
//        if (!$bool) {
//            throw $this->createNotFoundException($this->translator->trans('error.class'));
//        }
//    }

    /** STATIC METHODS */

    /**
     * Retourne la lettre de la Class en minuscule
     *
     * @param string $letter
     * @return string
     */
    protected static function Letter(string $letter): string
    {
        return strtoupper($letter);
    }

    /**
     * @param string $letter
     * @return bool
     */
    protected static function ControlLetter(string $letter): bool
    {
        return match ($letter) {
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => true,
            'S' => true,
            default => false,
        };
    }
}
