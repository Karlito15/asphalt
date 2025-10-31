# Initialization of App


### Create Database
``` shell
php bin/console doctrine:database:create
```

### Launch Migration
``` shell
php bin/console doctrine:migrations:migrate --no-interaction
```

### Load Datas
``` shell
php bin/console asphalt:database:migration import
```
