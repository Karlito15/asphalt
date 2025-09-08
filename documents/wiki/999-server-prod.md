# Server Prod

### MEP
``` cmd
php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json

php bin/console assets:install --env prod
php bin/console assets:install --symlink public
php bin/console importmap:install
php bin/console asset-map:compile
```

---

``` cmd
ssh sako@nastradamus -p 57995
cd /volume3/web/Symfony/Asphalt/www/
git reset --hard HEAD
git pull origin master
php82 bin/console cache:clear --env prod
```

---

``` cmd
ssh sako@nastradamus -p 57995

cd /volume3/web/Symfony/Asphalt/www/
php bin/console debug:dotenv
composer update --no-dev --optimize-autoloader
php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json
php bin/console assets:install --env prod
php bin/console importmap:install
php bin/console asset-map:compile
php bin/console cache:clear --env prod
```
