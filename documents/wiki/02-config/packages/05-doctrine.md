doctrine:
    dbal:
        charset:  utf8
        driver:   pdo_mysql
        dbname:   '%env(resolve:DATABASE_NAME)%'
        host:     '%env(resolve:DATABASE_HOST)%'
        port:     '%env(resolve:DATABASE_PORT)%'
        user:     '%env(resolve:DATABASE_USER)%'
        password: '%env(resolve:DATABASE_PASS)%'
#        url:       '%env(resolve:DATABASE_URL)%'

        # IMPORTANT: You MUST configure your server version,
        # either here or in the DATABASE_URL env var (see .env file)
#        server_version: '10'
        server_version: '%env(resolve:DATABASE_SERVER_VERSION)%'

        profiling_collect_backtrace: '%kernel.debug%'
        use_savepoints: true
    orm:
        auto_generate_proxy_classes: true
        auto_mapping: true
        enable_lazy_ghost_objects: true
        identity_generation_preferences:
            Doctrine\DBAL\Platforms\PostgreSQLPlatform: identity
        naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
        report_fields_where_declared: true
        validate_xml_mapping: true
        mappings:
            App:
                type: attribute
                is_bundle: false
                dir: '%kernel.project_dir%/src/Entity'
                prefix: 'App\Entity'
                alias: App
            Loggable:
                type: attribute
                is_bundle: false
                dir: "%kernel.project_dir%/vendor/gedmo/doctrine-extensions/src/Loggable/Entity"
                prefix: Gedmo\Loggable\Entity
                alias: GedmoLoggable
        filters:
            softdeleteable:
                class: Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter
                enabled: true
        controller_resolver:
            auto_mapping: false
        second_level_cache:
            enabled: true
            region_cache_driver:
                type: service
                id: cache.app
            regions:
                append_only:
                    lifetime: 8640000

when@test:
    doctrine:
        dbal:
            # "TEST_TOKEN" is typically set by ParaTest
            dbname_suffix: '_test%env(default::TEST_TOKEN)%'

when@prod:
    doctrine:
        orm:
            auto_generate_proxy_classes: false
            proxy_dir: '%kernel.build_dir%/doctrine/orm/Proxies'
            query_cache_driver:
                type: pool
                pool: doctrine.system_cache_pool
            result_cache_driver:
                type: pool
                pool: doctrine.result_cache_pool

    framework:
        cache:
            pools:
                doctrine.result_cache_pool:
                    adapter: cache.app
                doctrine.system_cache_pool:
                    adapter: cache.system
