<?php

namespace App\Domain\Abstract;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @param array $datas
     * @return array
     */
    protected static function breadcrumb(array $datas = []): array
    {
        foreach ($datas as $item) {
            $breadcrumb[] = [
                'label'  => $item['label'] ?? '',
                'route'  => $item['route'] ?? null,
                'params' => $item['params'] ?? [],
            ];
        }

        return $breadcrumb;
    }
}
