``` yaml
monolog:
    channels:
        - deprecation # Deprecations are logged in the dedicated "deprecation" channel when it exists

when@dev:
    monolog:
        handlers:
            main:
                # type: stream
                # path: "%kernel.logs_dir%/%kernel.environment%.log"
                # level: debug
                # channels: ["!event"]
                type: rotating_file
                path: "%kernel.logs_dir%/%kernel.environment%.log"
                level: INFO # DEBUG | INFO | NOTICE | ERROR
                max_files: 7
                channels: ["!event"]
                date_format: Y-m-d
                filename_format: '{date}-{filename}'
                ident: true
            # uncomment to get logging in your browser
            # you may have to allow bigger header sizes in your Web server configuration
            #firephp:
            #    type: firephp
            #    level: info
            #chromephp:
            #    type: chromephp
            #    level: info
            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine", "!console"]

when@test:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                channels: ["!event"]
            nested:
                type: stream
                path: "%kernel.logs_dir%/%kernel.environment%.log"
                level: debug

when@prod:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                buffer_size: 50 # How many messages should be saved? Prevent memory leaks
            nested:
                type: stream
                path: php://stderr
                level: debug
                formatter: monolog.formatter.json
            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine"]
            deprecation:
                type: stream
                channels: [deprecation]
                path: php://stderr
                formatter: monolog.formatter.json
```


``` yaml
monolog:
    channels:
        - deprecation # Deprecations are logged in the dedicated "deprecation" channel when it exists

when@dev:
    monolog:
        handlers:
            # 2025/07/16
            # main:
                # type: stream
                # path: "%kernel.logs_dir%/%kernel.environment%.log"
                # level: debug
                # channels: ["!event"]
                # type:           rotating_file
                # path:           "%kernel.logs_dir%/%kernel.environment%.log"
                # level:          DEBUG # DEBUG | INFO | NOTICE | WARNING | ERROR | CRITICAL | ALERT | EMERGENCY
                # max_files:      7
                # channels:       ["!event"]
                # date_format:    Y-m-d
                # ident:          true
            # uncomment to get logging in your browser
            # you may have to allow bigger header sizes in your Web server configuration
            #firephp:
            #    type: firephp
            #    level: info
            #chromephp:
            #    type: chromephp
            #    level: info
            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine", "!console"]
            # 2025/07/16
            security:
                # log all messages (since debug is the lowest level)
                level:          debug
                type:           stream
                path:           '%kernel.logs_dir%/security.log'
                channels:       ["security"]
            main:
                type:           rotating_file
                max_files:      7
                date_format:    Y-m-d
                filename_format: '{date}-{filename}'
                path:           '%kernel.logs_dir%/%kernel.environment%.all.log'
                level:          info # info
            main_error:
                type:           fingers_crossed
                action_level:   error
                handler:        streamed_error
            streamed_error:
                type:           rotating_file
                max_files:      7
                date_format:    Y-m-d
                filename_format: '{date}-{filename}'
                path:           '%kernel.logs_dir%/%kernel.environment%.error.log'
                level:          error # info
            main_critical:
                type:           fingers_crossed
                action_level:   critical
                handler:        grouped_critical
            grouped_critical:
                type:           group
                members:        ['streamed_critical']
            streamed_critical:
                type:           rotating_file
                max_files:      7
                date_format:    Y-m-d
                filename_format: '{date}-{filename}'
                path:           '%kernel.logs_dir%/%kernel.environment%.critical.log'
                level:          critical # info
            deprecation:
                type:           stream
                channels:       [deprecation]
                path:           '%kernel.logs_dir%/%kernel.environment%.deprecation.log'
                formatter:      monolog.formatter.line
            doctrine:
                type:           rotating_file
                max_files:      7
                date_format:    Y-m-d
                filename_format: '{date}-{filename}'
                channels:       ['doctrine']
                path:           '%kernel.logs_dir%/%kernel.environment%.doctrine.log'
                formatter:      monolog.formatter.line
                min_level:      notice
            event:
                type:           rotating_file
                max_files:      7
                date_format:    Y-m-d
                filename_format: '{date}-{filename}'
                channels:       ['event']
                path:           '%kernel.logs_dir%/%kernel.environment%.event.log'
                formatter:      monolog.formatter.line
                min_level:      warning

when@test:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                channels: ["!event"]
            nested:
                type: stream
                path: "%kernel.logs_dir%/%kernel.environment%.log"
                level: debug

when@prod:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                action_level: error
                handler: nested
                excluded_http_codes: [404, 405]
                buffer_size: 50 # How many messages should be saved? Prevent memory leaks
            nested:
                type: stream
                path: php://stderr
                level: debug
                formatter: monolog.formatter.json
            console:
                type: console
                process_psr_3_messages: false
                channels: ["!event", "!doctrine"]
            deprecation:
                type: stream
                channels: [deprecation]
                path: php://stderr
                formatter: monolog.formatter.json
```
