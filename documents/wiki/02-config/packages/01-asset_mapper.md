framework:
    asset_mapper:
        enabled: true
        # The paths to make available to the asset mapper.
        paths:
            - assets/
        missing_import_mode: strict

when@prod:
    framework:
        asset_mapper:
            missing_import_mode: warn
