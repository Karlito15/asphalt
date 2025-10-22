<?php

declare(strict_types=1);

namespace App\Trait\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

trait WebTrait
{
    /**
     * Retourne les liens vers la page index, la page création & de suppression
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
     * Redirection vers la page index
     *
     * @return RedirectResponse
     */
    private function redirectToIndex(): RedirectResponse
    {
        return $this->redirectToRoute(self::$index, [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param bool $bool
     * @return void
     */
    private function return404(bool $bool): void
    {
        if (!$bool) {
            throw $this->createNotFoundException($this->translator->trans('error.class'));
        }
    }
}
