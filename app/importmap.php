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
        'path' => './assets/scripts/app.js',
        'entrypoint' => true,
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@hotwired/turbo' => [
        'version' => '8.0.23',
    ],
    'tom-select/dist/css/tom-select.default.css' => [
        'version' => '2.5.2',
        'type' => 'css',
    ],
    'tom-select/dist/css/tom-select.bootstrap5.css' => [
        'version' => '2.5.2',
        'type' => 'css',
    ],
    'jquery' => [
        'version' => '4.0.0',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.8',
        'type' => 'css',
    ],
    'bootstrap-table' => [
        'version' => '1.27.1',
    ],
    'bootstrap-table/dist/bootstrap-table.min.css' => [
        'version' => '1.27.1',
        'type' => 'css',
    ],
    'fontawesome' => [
        'version' => '5.6.3',
    ],
    'htmx.org' => [
        'version' => '2.0.8',
    ],
    'sweetalert' => [
        'version' => '2.1.2',
    ],
];
