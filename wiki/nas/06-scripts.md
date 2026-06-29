# NAS 

## Scripts  

### Composer Scripts
``` shell
php84 /volume3/web/WWW-CDN/composer.phar run-script post-update-cmd
```

### Clear Cache
``` shell
php84 bin/console cache:clear --env prod
```

### Install Assets
``` shell
php84 bin/console assets:install public
```

### Import Install
``` shell
php84 bin/console importmap:install
```

### Assets Compile
``` shell
php84 bin/console asset-map:compile
```
