# Asset Mapper

[Documentation](https://symfony.com/doc/current/frontend/asset_mapper.html)

#### Edit File
``` php
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],

```
TO
``` php
    'app' => [
        'path' => './assets/scripts/app.js',
        'entrypoint' => true,
    ],

```

#### Compile
``` shell
php bin/console asset-map:compile
```

#### Libraries
``` shell
php bin/console importmap:require bootstrap
php bin/console importmap:require bootstrap-table
php bin/console importmap:require fontawesome
php bin/console importmap:require jquery
php bin/console importmap:require htmx.org
php bin/console importmap:require sweetalert2
```

#### Install libraries
``` shell
php bin/console importmap:install
```

#### Manage libraries
``` shell
php bin/console importmap:outdated
```

``` shell
php bin/console importmap:update
```

#### Installation
``` shell
composer require symfony/asset-mapper symfony/asset symfony/twig-pack
```

