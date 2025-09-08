# Axios

````textmate
npm install -D ./vendor/friendsofsymfony/jsrouting-bundle/Resources/
yarn add -D ./vendor/friendsofsymfony/jsrouting-bundle/Resources/
php bin/console assets:install --symlink public
php bin/console fos:js-routing:dump
php bin/console fos:js-routing:dump --format=json --target=assets/js/routes.json
````

WEBPACK
````js
const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../public/bundles/fosjsrouting/js/router.min';
````
