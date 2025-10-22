# Install

## Libraries

#### Production

``` shell
composer remove --no-scripts symfony/ux-turbo
```

``` shell
composer require --no-scripts composer/package-versions-deprecated
```
``` shell
composer require --no-scripts karlito-web/toolbox-php-file
```
``` shell
composer require --no-scripts karlito-web/toolbox-php-yaml
```
``` shell
composer require --no-scripts league/csv
```
``` shell
composer require --no-scripts stof/doctrine-extensions-bundle
```
``` shell
composer require --no-scripts symfony/apache-pack
```
``` shell
composer require --no-scripts symfony/event-dispatcher
```
``` shell
composer require --no-scripts symfony/ux-twig-component
```
``` shell
composer require --no-scripts symfonycasts/sass-bundle
```
``` shell
composer require --no-scripts twig/cache-extra
```
``` shell
composer require --no-scripts twig/intl-extra
```
``` shell
composer require --no-scripts twig/string-extra
```


``` shell
composer require --no-scripts symfonycasts/verify-email-bundle
```
``` shell
composer require --no-scripts twbs/bootstrap
```
``` shell
composer require --no-scripts symfony/ux-autocomplete
```
``` shell
composer require --no-scripts symfony/ux-chartjs
```
``` shell
composer require --no-scripts twig/markdown-extra
```

#### Development
``` shell
composer require --dev --no-scripts doctrine/doctrine-fixtures-bundle
```
``` shell
composer require --dev --no-scripts fakerphp/faker
```
``` shell
composer require --dev --no-scripts phpstan/phpstan-symfony
```
``` shell
composer require --dev --no-scripts symfony/phpunit-bridge
```

#### Front
``` shell
php bin/console importmap:require tom-select/dist/css/tom-select.default.css
```
``` shell
php bin/console importmap:require tom-select/dist/css/tom-select.bootstrap5.css
```
``` shell
php bin/console importmap:require jquery
```
``` shell
php bin/console importmap:require bootstrap
```
``` shell
php bin/console importmap:require bootstrap-table
```
``` shell
php bin/console importmap:require fontawesome
```
``` shell
php bin/console importmap:require htmx.org
```
``` shell
php bin/console importmap:require sweetalert
```
``` shell
php bin/console asset-map:compile
```
