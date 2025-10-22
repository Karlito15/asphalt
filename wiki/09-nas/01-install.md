# NAS 

### Connect to NAS
``` shell
ssh gian@NASako -p 57995
```

``` shell
cd /volume3/web/Symfony/Asphalt/
```

### Clone Repo
``` shell
git clone https://github.com/Karlito15/asphalt.git Asphalt
```

### Modify Permissions
``` shell
sudo chmod -R a+rw documents/
```
``` shell
sudo chmod -R a+rw vars/
```
``` shell
sudo chmod -R a+rw www/vendor/
```
``` shell
sudo chmod -R a+rw www/public/
```

### .env
``` shell
php82 /volume3/web/WWW-CDN/composer.phar dump-env prod
```

### Composer
``` shell
php82 /volume3/web/WWW-CDN/composer.phar install --no-dev --no-scripts --optimize-autoloader
```

### Database
``` shell
php82 bin/console doctrine:database:drop --force
```
``` shell
php82 bin/console doctrine:database:create
```
``` shell
php82 bin/console doctrine:migrations:migrate --no-interaction
```
``` shell
php82 bin/console asphalt:database:migration import
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
