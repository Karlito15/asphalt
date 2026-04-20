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

### A9 Import
``` shell
php84 bin/console asphalt:csv:migration import
```

### A9 Export
``` shell
php84 bin/console asphalt:csv:migration export
```

### A9 CRON COUNTS
``` shell
php84 bin/console asphalt:cron:count:brand
```
``` shell
php84 bin/console asphalt:cron:count:class
```

### A9 CRON UPDATE GARAGE
``` shell
php84 bin/console asphalt:cron:garage:gauntlet
```
``` shell
php84 bin/console asphalt:cron:garage:level
```
``` shell
php84 bin/console asphalt:cron:garage:status
```
``` shell
php84 bin/console asphalt:cron:garage:control
```
