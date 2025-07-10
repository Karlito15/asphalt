<?php

declare(strict_types=1);

namespace App\Able\Controller;

use Symfony\Component\HttpFoundation\Response;

trait WebAble
{
    /**
     * @return array
     */
    public static function getLinksPage(): array
    {
        return [
            'index' => self::$index,
            'create' => self::$create
        ];
    }

    /**
     * @return void
     */
    public function redirectToIndex(): void
    {
        $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }
}
