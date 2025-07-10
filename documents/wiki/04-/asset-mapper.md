# Asset Mapper

[Documentation](https://symfony.com/doc/current/frontend/asset_mapper.html)

#### Compile
``` shell
php bin/console asset-map:compile
```

#### Libraries
``` shell
php bin/console importmap:require bootstrap
php bin/console importmap:require bootstrap-table
php bin/console importmap:require htmx.org
php bin/console importmap:require sweetalert2
php bin/console importmap:require fontawesome
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

