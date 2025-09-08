<?php

namespace App\Able;

trait ControllerApiAble
{
    /**
     * @return array
     */
    public static function getHeaders(): array // Request $request
    {
        // return $request->headers->all();
        return [
            'Cache-Control' => 'no-cache, private',
            'Content-Type'  => 'application/json',
            'X-Robots-Tag'  => 'noindex',
        ];
    }

    /**
     * @param array $config
     * @return array
     */
    public static function getContext(array $config = []): array
    {
        $default = [
            'groups' => 'public'
        ];

        return array_merge($default, $config);
    }
}
