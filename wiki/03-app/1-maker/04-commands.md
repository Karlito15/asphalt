# List of Commands

### Cron
``` shell
php bin/console make:command Application\Command\Cron\CheckUp\GarageUpdateCommand
```
``` shell
php bin/console make:command Application\Command\Cron\Count\BrandCommand
```
``` shell
php bin/console make:command Application\Command\Cron\Count\ClassCommand
```
``` shell
php bin/console make:command Application\Command\Cron\Count\TagCommand
```

### CSV
``` shell
php bin/console make:command Application\Command\CSV\AppMigrationCommand
```
``` shell
php bin/console make:command Application\Command\CSV\AppOrderByClassCommand
```
``` shell
php bin/console make:command Application\Command\CSV\GaragesCommand
```
``` shell
php bin/console make:command Application\Command\CSV\InventoriesCommand
```
``` shell
php bin/console make:command Application\Command\CSV\MissionsCommand
```
``` shell
php bin/console make:command Application\Command\CSV\RacesCommand
```
``` shell
php bin/console make:command Application\Command\CSV\SettingsCommand
```

### Database
``` shell
php bin/console make:command Application\Command\Database\TruncateCommand
```

### YAML

#### Index
``` shell
php bin/console make:command Application\Command\YAML\Index\GarageCommand
```
``` shell
php bin/console make:command Application\Command\YAML\Index\MissionCommand
```
``` shell
php bin/console make:command Application\Command\YAML\Index\RaceCommand
```

#### Page
``` shell
php bin/console make:command Application\Command\YAML\Page\PageCommand
```

#### Sheet
``` shell
php bin/console make:command Application\Command\YAML\Sheet\GarageCommand
```
``` shell
php bin/console make:command Application\Command\YAML\Sheet\InventoryCommand
```
``` shell
php bin/console make:command Application\Command\YAML\Sheet\StatCommand
```
