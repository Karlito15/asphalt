parameters:
    level: 9
    paths:
        - bin/
        - public/
        - src/
    excludePaths:
        - config/
        - tests/
    fileExtensions:
        - php
    tmpDir: ../vars/phpstan
    phpVersion: 80415 # PHP 8.4.15
#includes:
#    - vendor/phpstan/phpstan-symfony/extension.neon
#    - vendor/phpstan/phpstan-symfony/rules.neon



php vendor/bin/phpstan analyse -c phpstan.dist.neon --memory-limit 4G --error-format=table
php vendor/bin/phpstan analyse -c phpstan.dist.neon --memory-limit 4G --error-format=table > ../vars/phpstan/result.txt