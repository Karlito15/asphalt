# Events

## CarEvent
````textmate
switchFull
switchGold
switchToUpgrade
addClassOrder
reOrderByClass
reOrderByStat
````

### switchFull
Compare les champs de l'Entity Garage Upgrade et met à jour la table `Car`

### switchGold
Compare les champs de l'Entity Garage Upgrade et met à jour la table `Car`

### switchToUpgrade
Vérifie si les champs "Full" & "Gold" sont true Alors toUpgrade passe à false et met à jour la table `Car`

### addClassOrder
Remplie la colonne ClassOrder

### reOrderByClass
Re Order Cars by Class

### reOrderByStat
Re Order Cars by Stat Max

## GarageBlueprintEvent
### calcTotal
Calcule le total des Blueprints pour une voiture et met à jour la table `garage_blueprint`

## GarageStatEvent
### calcAverage
Calcule la moyenne des Stats pour une voiture et met à jour la table `garage_stat`


# Manager

#### BlueprintManager

Calcule le total des Blueprints pour une voiture
````textmate
setTotal()
````

#### BooleanManager

````textmate
switchUnlock(Garage $garage)
switchFullBlueprint(Garage $garage)
switchFullUpgrade(Garage $garage)
switchGold(Garage $garage)
switchToUnlock(Garage $garage)
switchToInstallUpgrade(Garage $garage)
switchToInstallCommon(Garage $garage)
switchToInstallRare(Garage $garage)
switchToInstallEpic(Garage $garage)
````

#### GarageManager

Renseigne la colonne classOrder en fonction de la valeur de `class`
````textmate
initializeClassOrder(Garage $garage)
````

Renseigne la table Garage BlueprintService en fonction de la valeur `stars`
````textmate
initializeBlueprint(Garage $garage)
````

Renseigne la table Garage Boolean
````textmate
initializeBoolean(Garage $garage)
````

Renseigne la table Garage Rank en fonction de la valeur `stars`
````textmate
initializeRank(Garage $garage)
````

Renseigne les tables Garage Stat
````textmate
initializeStats(Garage $garage)
````

Renseigne la table Garage Upgrade
````textmate
initializeUpgrade(Garage $garage)
````

Calcule la position de la voiture en fonction de sa Class
````textmate
reOrderByClass(Garage $garage, GarageRepository $repository)
````

Calcule la position de la voiture en fonction des Stats
````textmate
reOrderByStat(Garage $garage, GarageRepository $repository)
````

#### StatManager

Calcule la moyenne des Stats pour une voiture
````textmate
setAverage(?float $speed, ?float $acceleration, ?float $handly, ?float $nitro)
````

#### UpgradeManager

````textmate

````
