# List of Commands


#### CRON
```text
php bin/console make:command Cron\GarageCommand
php bin/console make:command Cron\SettingBrandCarsNumberCommand
php bin/console make:command Cron\SettingClassCarsNumberCommand
php bin/console make:command Cron\StatisticalCommand
```


#### Export Datas
```text
php bin/console make:command Database\Export\AppCommand
php bin/console make:command Database\Export\GaragesCommand
php bin/console make:command Database\Export\InventoriesCommand
php bin/console make:command Database\Export\MissionsCommand
php bin/console make:command Database\Export\RacesCommand
php bin/console make:command Database\Export\SettingsCommand
```


#### Import Datas
```text
php bin/console make:command Database\Import\AppCommand
php bin/console make:command Database\Import\GaragesCommand
php bin/console make:command Database\Import\InventoriesCommand
php bin/console make:command Database\Import\MissionsCommand
php bin/console make:command Database\Import\RacesCommand
php bin/console make:command Database\Import\SettingsCommand
```


#### Purge Database
```text
php bin/console make:command Database\PurgeDBCommand
```
