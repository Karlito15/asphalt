``` yaml
doctrine_migrations:
    migrations_paths:
        # namespace is arbitrary but should be different from App\Migrations
        # as migrations classes should NOT be autoloaded
         'DoctrineMigrations': '%kernel.project_dir%/../migrations'
        # 'DoctrineMigrations': '%kernel.project_dir%/src/Migrations'

    # Use profiler to calculate and visualize migration status.
    enable_profiler:            true

    # Entity manager to use for migrations. This overrides the "connection" setting.
    em: 						default

    # Run all migrations in a transaction.
    all_or_nothing: 			true

    # Adds an extra check in the generated migrations to ensure that is executed on the same database type.
    check_database_platform: 	true

    # Path to your custom migrations template
    custom_template: 			~

    # Organize migrations mode. Possible values are: "BY_YEAR", "BY_YEAR_AND_MONTH", false
    organize_migrations: 		false

    # Whether or not to wrap migrations in a single transaction.
    transactional: 				true

    storage:
        # Default (SQL table) metadata storage configuration
        table_storage:
            table_name: '__migrations__'
            version_column_name: 'version'
            version_column_length: 192
            executed_at_column_name: 'executed_at'
            execution_time_column_name: 'execution_time'
```
