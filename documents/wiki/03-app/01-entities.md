# List of Entities


## Create Entities
```
php bin/console make:entity
```

#### App
```
php bin/console make:entity AppGarage
php bin/console make:entity AppInventory
php bin/console make:entity AppMission
php bin/console make:entity AppRace
```

#### Garages
```
php bin/console make:entity GarageBlueprint
php bin/console make:entity GarageBoolean
php bin/console make:entity GarageRank
php bin/console make:entity GarageStatMax
php bin/console make:entity GarageStatMin
php bin/console make:entity GarageUpgrade
```

#### Missions
```
php bin/console make:entity MissionTask
php bin/console make:entity MissionType
```

#### Races
```
php bin/console make:entity RaceMode
php bin/console make:entity RaceRegion
php bin/console make:entity RaceSeason
php bin/console make:entity RaceTime
php bin/console make:entity RaceTrack
```

#### Settings
```
php bin/console make:entity SettingBlueprint
php bin/console make:entity SettingBrand
php bin/console make:entity SettingClass
php bin/console make:entity SettingLevel
php bin/console make:entity SettingUnitPrice
```

## Create Migration
```
php bin/console make:migration
```

## Make Migration
```
php bin/console doctrine:migrations:migrate
```
