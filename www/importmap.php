<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@symfony/ux-live-component' => [
        'path' => './vendor/symfony/ux-live-component/assets/dist/live_controller.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.12',
    ],
    'tom-select' => [
        'version' => '2.4.1',
    ],
    '@orchidjs/sifter' => [
        'version' => '1.1.0',
    ],
    '@orchidjs/unicode-variants' => [
        'version' => '1.1.2',
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.default.min.css' => [
        'version' => '2.4.1',
        'type' => 'css',
    ],
    'chart.js' => [
        'version' => '4.4.7',
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'bootstrap' => [
        'version' => '5.3.3',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.3',
        'type' => 'css',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    '@kurkle/color' => [
        'version' => '0.3.4',
    ],
    'htmx.org' => [
        'version' => '1.9.12',
    ],
    'sweetalert2' => [
        'version' => '11.15.10',
    ],
    'bootstrap-table' => [
        'version' => '1.24.0',
    ],
    'bootstrap-table/dist/bootstrap-table.min.css' => [
        'version' => '1.24.0',
        'type' => 'css',
    ],
];
