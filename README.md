# Asphalt 9

## Symfony App for Asphalt Garage Database
 
#### Base on : Symfony 7.3

###### Charset
``` text
UTF-8
```

[Github](https://github.com/Karlito15/asphalt)

###### NAS
``` shell
ssh gian@NASako -p 57995
```
``` shell
cd /volume3/web/Symfony/Asphalt/app/
```
composer install
``` shell
php82 /volume3/web/WWW-CDN/composer.phar update
```
cache
``` shell
php82 bin/console cache:clear --env prod
```
assets (bundles)
``` shell
php82 bin/console assets:install --env prod
```
assets (project)
``` shell
php82 bin/console asset-map:compile
```
export DB to CSV
``` shell
php82 bin/console asphalt:database:migration export
```

###### NAS - Droits

``` shell
sudo chmod -R 0777 documents/
```

``` shell
sudo chmod -R 0777 vars/
```

``` shell
sudo chgrp -R http documents/
```

``` shell
sudo chgrp -R http vars/
```

###### NAS - Installation
dump env
``` shell
php82 /volume3/web/WWW-CDN/composer.phar dump-env prod
```
dump env
``` shell
php82 bin/console importmap:install
```
