"scripts": {
    "db-reset": [
        "bin/console doctrine:database:drop --force --if-exists",
        "bin/console doctrine:database:create",
        "bin/console doctrine:schema:update --force",
        "bin/console doctrine:fixtures:load --no-interaction"
    ],
    "tests": "vendor/bin/phpunit",
    "check-code": [
        "@tests",
        "vendor/bin/phpstan analyse src"
    ],
    "quality": [
        "phpstan analyse src",
        "php-cs-fixer fix --dry-run"
    ]
}