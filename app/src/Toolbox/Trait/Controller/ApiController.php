<?php

declare(strict_types=1);

namespace App\Toolbox\Trait\Controller;

trait ApiController
{
    /**
     * @return array
     */
    public static function getHeaders(): array
    {
        return [
            'Cache-Control'    => 'no-cache, private',
            'Content-Type'     => 'application/json',
            'X-Robots-Tag'     => 'noindex',
            'Referrer-Policy'  => 'strict-origin-when-cross-origin',
            // 'X-Total-Count'  => 0,
        ];
    }

    /**
     * @param array $config
     * @return array
     */
    public static function getContext(array $config = []): array
    {
        $default = [
            'groups' => 'index'
        ];

        return array_merge($default, $config);
    }
}
