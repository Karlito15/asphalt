# List of Commands


## CRON
```text
php bin/console asphalt:cron:garage       [a:c:g|asphalt-cron-garage]       Load all Managers
php bin/console asphalt:cron:stat         [a:c:s|asphalt-cron-stat]         Generate Stats
```


## Database Datas
```text
php bin/console asphalt:database:all import         [a:d:g|asphalt-database-all]        Importe Toutes les données
php bin/console asphalt:database:all export         [a:d:g|asphalt-database-all]        Exporte Toutes les données
php bin/console asphalt:database:garage import      [a:d:g|asphalt-database-garage]     Importe les données pour le garage
php bin/console asphalt:database:garage export      [a:d:g|asphalt-database-garage]     Exporte les données pour le garage
php bin/console asphalt:database:inventory import   [a:d:i|asphalt-database-inventory]  Importe les données pour l'inventaire
php bin/console asphalt:database:inventory export   [a:d:i|asphalt-database-inventory]  Exporte les données pour l'inventaire
php bin/console asphalt:database:mission import     [a:d:m|asphalt-database-mission]    Importe les données pour les missions
php bin/console asphalt:database:mission export     [a:d:m|asphalt-database-mission]    Exporte les données pour les missions
php bin/console asphalt:database:race import        [a:d:r|asphalt-database-race]       Importe les données pour les courses
php bin/console asphalt:database:race export        [a:d:r|asphalt-database-race]       Exporte les données pour les courses
php bin/console asphalt:database:setting import     [a:d:r|asphalt-database-setting]    Importe les données pour les settings
php bin/console asphalt:database:setting export     [a:d:r|asphalt-database-setting]    Exporte les données pour les settings
```


## Database Truncate 
```text
php bin/console asphalt:database:clear    [a:d:c|asphalt-database-clean]    Purge la base de données
```
