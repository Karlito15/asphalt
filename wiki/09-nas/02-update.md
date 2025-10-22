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
