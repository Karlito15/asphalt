#!/bin/bash
clear

# Composer
php82 /volume3/web/WWW-CDN/composer.phar update --no-scripts

# Symfony
php82 /volume3/web/Symfony/Asphalt/app/bin/console about

# Project
php82 /volume3/web/Symfony/Asphalt/app/bin/console cache:clear --env prod
php82 /volume3/web/Symfony/Asphalt/app/bin/console assets:install public
php82 /volume3/web/Symfony/Asphalt/app/bin/console importmap:install
php82 /volume3/web/Symfony/Asphalt/app/bin/console importmap:update
php82 /volume3/web/Symfony/Asphalt/app/bin/console asset-map:compile

# Commands
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-class S
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-class A
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-class B
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-class C
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-class D

php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:setting-brand

# Export
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:cron:order-car export
php82 /volume3/web/Symfony/Asphalt/app/bin/console asphalt:database:migration export
