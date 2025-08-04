<?php

declare(strict_types=1);

namespace App\Able\Controller;

use Symfony\Component\HttpFoundation\Response;

trait WebAble
{
    /**
     * Retourne les liens vers la page index et la page création
     *
     * @return array
     */
    private static function getLinksPage(): array
    {
        return [
            'index'  => self::$index,
            'create' => self::$create,
            'delete' => self::$delete,
        ];
    }

    /**
     * @return void
     */
    private function redirectToIndex(): void
    {
        $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
