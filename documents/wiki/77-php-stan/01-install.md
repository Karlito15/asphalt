
composer require --dev phpstan/phpstan-symfony

Include in PHPStan Config
```
includes:
    - vendor/phpstan/phpstan-symfony/extension.neon


includes:
    - vendor/phpstan/phpstan-symfony/rules.neon
    
```


```
parameters:
    symfony:
        containerXmlPath: var/cache/dev/srcDevDebugProjectContainer.xml
        # or with Symfony 4.2+
        containerXmlPath: var/cache/dev/srcApp_KernelDevDebugContainer.xml
        # or with Symfony 5+
        containerXmlPath: var/cache/dev/App_KernelDevDebugContainer.xml
    # If you're using PHP config files for Symfony 5.3+, you also need this for auto-loading of `Symfony\Config`:
    scanDirectories:
        - var/cache/dev/Symfony/Config
    # If you're using PHP config files (including the ones under packages/*.php) for Symfony 5.3+,
    # you need this to load the helper functions (i.e. service(), env()):
    scanFiles:
        - vendor/symfony/dependency-injection/Loader/Configurator/ContainerConfigurator.php
```
