# see https://symfony.com/doc/current/reference/configuration/framework.html
framework:
    annotations: false
    # assets configuration
#    assets:
#        json_manifest_path:   '%kernel.project_dir%/public/build/manifest.json'
    csrf_protection: true
    default_locale: 'fr'
    handle_all_throwables: true
    http_cache: true
    http_method_override: true
    ide: phpstorm
    secret: '%env(APP_SECRET)%'

    # Note that the session will be started ONLY if you read or write from it.
    session: true

    #esi: true
    #fragments: true
    php_errors:
        log: true

#    http_client:
#        default_options:
#            http_version: '2.0'
#            max_host_connections: 10
#            max_redirects: 5

when@test:
    framework:
        test: true
        session:
            storage_factory_id: session.storage.factory.mock_file
