# NAS  

#### Connect to NAS
``` shell
ssh gian@NASako -p 57995
```

#### XXX
``` shell
cd /volume3/web/Symfony/Asphalt/
```

#### XXX
``` shell
git status
```

#### XXX
``` shell
git add -A
```

#### XXX
``` shell
git commit -m "Commit Before Update"
```

#### Update Repo
``` shell
git pull origin main
```

#### XXX
``` shell
git add -A
```

#### XXX
``` shell
git commit -m "Merge Commit"
```

#### XXX
``` shell
cd app/
```

## Composer
``` shell
php84 /volume3/web/WWW-CDN/composer.phar update --no-dev --no-scripts
```

## Clear Cache (Symfony & Doctrine)
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console cache:clear --env prod
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console cache:clear --env dev
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-metadata
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-query
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-result
```

## Assets
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console assets:install public
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console importmap:install
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console importmap:update
```
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asset-map:compile
```

## A9 :: Commands
#### Compte le nombre de voitures par Marque
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:count:brand
```
#### Compte le nombre de voitures par Class
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:count:class
```
#### Mets à jour la Voiture
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:garage:status
```
#### Mets à jour la Voiture
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:garage:control
```
#### Mets à jour la Voiture
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:garage:gauntlet
```
#### Mets à jour la Voiture
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:garage:level
```
#### Export CSV
``` shell
php84 -d memory_limit=512M /volume3/web/Symfony/Asphalt/app/bin/console asphalt:csv:migration export
```
