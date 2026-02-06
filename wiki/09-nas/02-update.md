# NAS 

### Connect to NAS
``` shell
ssh gian@NASako -p 57995
```

``` shell
cd /volume3/web/Symfony/Asphalt/www/
```

### Update Repo
``` shell
git pull origin main
```

### Composer
``` shell
php82 /volume3/web/WWW-CDN/composer.phar update --no-dev --no-scripts --optimize-autoloader
```

``` shell
php82 /volume3/web/WWW-CDN/composer.phar run-script post-update-cmd
```

### Public
``` shell
php82 /volume3/web/WWW-CDN/composer.phar run-script post-update-cmd
```
OR
``` shell
php82 bin/console cache:clear --env prod
```
``` shell
php82 bin/console assets:install public
```
``` shell
php82 bin/console sass:build
```
``` shell
php82 bin/console importmap:install
```
``` shell
php82 bin/console asset-map:compile
```
``` shell
php82 bin/console asphalt:database:migration export
```
