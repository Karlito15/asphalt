# parameters.yaml

``` yaml
parameters:
    metas:
        title:              'Asphalt Legends Unite'
        author:             'Giancarlo PALUMBO'
        email:              'giancarlo.palumbo@free.fr'
        description:        ~
        generator:          ~
    classes:
        table-index:        'table table-bordered table-striped text-light'
        classes.table:          'btn btn-outline-info border border-info rounded-right rounded-4 py-0'
        input:              'form-control form-control-sm bg-transparent text-center fw-bolder'
    games:
        pack:               6
        pack_price:         900
    images:
        avatar:             'images/sako-01.jpg'
when@dev:
    parameters:
        cache_lifetime:
            dashboards:         600 # 10 min
            garages:            600 # 10 min
            missions:           600 # 10 min
            races:              600 # 10 min
            sitemaps:           600 # 10 min
        images:
            logo:          'images/logo-yellow.png'
when@prod:
    parameters:
        cache_lifetime:
            dashboards:         3600    # (60 * 60 = 1 hour)
            garages:            3600    # (60 * 60 = 1 hour)
            missions:           3600    # (60 * 60 = 1 hour)
            races:              2678400 # (60 * 60 * 24 * 31 = 1 month)
            sitemaps:           2678400 # (60 * 60 * 24 * 31 = 1 month)
        images:
            logo:          'images/logo-white.png'

```
