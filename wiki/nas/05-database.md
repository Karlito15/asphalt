# NAS 

## Database  

### Drop
``` shell
php84 bin/console doctrine:database:drop --force --if-exists
```

### Create
``` shell
php84 bin/console doctrine:database:create --if-not-exists
```

### Migration
``` shell
php84 bin/console doctrine:migrations:migrate --no-interaction
```

``` shell
php84 bin/console doctrine:migrations:migrate prev --no-interaction
```
