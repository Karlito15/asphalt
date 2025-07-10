# Scripts


## Composer

#### Update
``` shell
composer update --optimize-autoloader
```

#### Env
``` shell
composer dump-env dev
```

## Migration

#### Diff
``` shell
php bin/console doctrine:migrations:diff
```

#### Migrate
``` shell
php bin/console doctrine:migrations:migrate
```

#### Asset Mapper
``` shell
php bin/console asset-map:compile
```
