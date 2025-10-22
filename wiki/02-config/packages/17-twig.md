``` yaml
twig:
    cache:                      '%kernel.cache_dir%/twig'
    date:
        format:                 'Y-m-d, H:i:s'
        interval_format:        '%d days'
        # The timezone used when formatting dates, when set to null, the timezone returned by date_default_timezone_get() is used
        timezone:               Europe/Paris
    default_path:               '%kernel.project_dir%/templates'
    file_name_pattern:          '*.twig'
    form_themes:
        - bootstrap_5_layout.html.twig
    number_format:
        decimals:               0
        decimal_point:          ','
        thousands_separator:    ' '
    paths:
        '%kernel.project_dir%/templates': 'App'
    globals:
        metas:                  '%metas%'
        classes:                '%classes%'
        games:                  '%games%'
        images:                 '%images%'
when@test:
    twig:
        strict_variables: true

```
