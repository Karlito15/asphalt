#!/bin/bash
clear

# Composer
php84 /volume3/web/WWW-CDN/composer.phar update --no-scripts

# Symfony
php84 /volume3/web/Symfony/Asphalt/app/bin/console about

# Clear Cache (Symfony & Doctrine)
php84 /volume3/web/Symfony/Asphalt/app/bin/console cache:clear --env prod
php84 /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-metadata
php84 /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-query
php84 /volume3/web/Symfony/Asphalt/app/bin/console doctrine:cache:clear-result

# Assets
php84 /volume3/web/Symfony/Asphalt/app/bin/console assets:install public
php84 /volume3/web/Symfony/Asphalt/app/bin/console importmap:install
php84 /volume3/web/Symfony/Asphalt/app/bin/console importmap:update
php84 /volume3/web/Symfony/Asphalt/app/bin/console asset-map:compile

# Commands
#### Compte le nombre de voitures par Marque
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:count:brand
#### Compte le nombre de voitures par Class
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:count:class
#### Mets à jour la Voiture
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:checkup:garage
#### Créer le listing du Garage
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:yaml:index:garage
#### Créer le listing des Missions
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:yaml:index:mission
#### Créer le listing des Courses
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:yaml:index:race
#### Export Garage Order By Class
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:csv:order:class export

# Export Database
#### Exporte toutes les données
php84 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:csv:migration export
