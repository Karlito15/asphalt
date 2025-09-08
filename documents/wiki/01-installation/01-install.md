# Install


## Symfony
``` cmd
symfony local:new Asphalt --webapp
```

## Libraries

#### Production
``` cmd
composer require composer/package-versions-deprecated --no-scripts
```
``` cmd
composer require friendsofsymfony/jsrouting-bundle --no-scripts
```
``` cmd
composer require league/csv --no-scripts
```
``` cmd
composer require stof/doctrine-extensions-bundle --no-scripts
```
``` cmd
composer require symfony/ux-autocomplete --no-scripts
```
``` cmd
composer require symfony/ux-chartjs --no-scripts
```
``` cmd
composer require symfony/ux-live-component --no-scripts
```
``` cmd
composer require symfony/ux-twig-component --no-scripts
```
``` cmd
composer require twig/cache-extra --no-scripts
```
``` cmd
composer require twig/intl-extra --no-scripts
```
``` cmd
composer require twig/markdown-extra --no-scripts
```
``` cmd
composer remove symfony/ux-turbo --no-scripts
```

#### Development
``` cmd
composer require --dev doctrine/doctrine-fixtures-bundle --no-scripts
```
``` cmd
composer require --dev fakerphp/faker --no-scripts
```
``` cmd
composer require --dev phpstan/phpstan-symfony
```


#### Optimize
``` cmd
composer update --optimize-autoloader
```

#### Front
``` cmd
php bin/console importmap:require tom-select/dist/css/tom-select.default.css
```
``` cmd
php bin/console importmap:require jquery
```
``` cmd
php bin/console importmap:require bootstrap
```
``` cmd
php bin/console importmap:require fontawesome
```
``` cmd
php bin/console asset-map:compile
```
