# Services

Modify 
-----------------

Add new lines
```yaml
imports:
    - { resource: '../../documents/yaml/parameters.yaml' }
```

Add in parameters
```yaml
    app.supported_locales:  'en|fr'
    app.env:                '%env(APP_ENV)%'
    locale:                 'fr'
```

Add to the end
```yaml

    # Cache
    Symfony\Component\Cache\Adapter\TagAwareAdapterInterface:
        class: Symfony\Component\Cache\Adapter\TagAwareAdapter
        arguments: ['@cache.app']

    # Commands
    Symfony\Component\DependencyInjection\ContainerInterface: '@service_container'
```
