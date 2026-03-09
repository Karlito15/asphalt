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

## Front

#### Asset Mapper
``` shell
php bin/console asset-map:compile
```

## Database
Vider la base de données  
[asphalt-database-truncate]
``` shell
php bin/console asphalt:csv:truncate
```

Exporte ou Importe toutes les données  
[asphalt-database-migration]
``` shell
php bin/console asphalt:csv:migration
```
``` shell
php bin/console asphalt:csv:migration export
```
``` shell
php bin/console asphalt:csv:migration import
```
Toutes les données pour le Garage  
[asphalt-database-garage]
``` shell
php bin/console asphalt:csv:garage
```
Toutes les données pour l'Inventaire  
[asphalt-database-inventory]
``` shell
php bin/console asphalt:csv:inventory
```
Toutes les données pour les Missions  
[asphalt-database-mission]
``` shell
php bin/console asphalt:csv:mission
```
Toutes les données pour les Courses  
[asphalt-database-race]
``` shell
php bin/console asphalt:csv:race
```
Toutes les données pour les Settings  
[asphalt-database-setting]
``` shell
php bin/console asphalt:csv:setting
```
Exporte toutes les fiches du garage  
[asphalt-sheet-garage]
``` shell
php bin/console asphalt:sheet:garage
```
