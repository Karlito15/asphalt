# Read the documentation: https://symfony.com/doc/current/bundles/StofDoctrineExtensionsBundle/index.html
# See the official DoctrineExtensions documentation for more details: https://github.com/doctrine-extensions/DoctrineExtensions/tree/main/doc
stof_doctrine_extensions:
    default_locale:                  'fr_FR'
    translation_fallback:            true
    persist_default_translation:     true
    skip_translation_on_load:        true
    orm:
        default:
            loggable: true
            sluggable: true
            softdeleteable: true
            timestampable: true
            translatable: false
            blameable: false
            tree: false
            ip_traceable: false
            sortable: false
            uploadable: false
            reference_integrity: false
    class:
        translatable: Gedmo\Translatable\TranslatableListener
        timestampable: Gedmo\Timestampable\TimestampableListener
        blameable: Gedmo\Blameable\BlameableListener
        sluggable: Gedmo\Sluggable\SluggableListener
        tree: Gedmo\Tree\TreeListener
        loggable: Gedmo\Loggable\LoggableListener
        sortable: Gedmo\Sortable\SortableListener
        softdeleteable: Gedmo\SoftDeleteable\SoftDeleteableListener
        uploadable: Gedmo\Uploadable\UploadableListener
        reference_integrity: Gedmo\ReferenceIntegrity\ReferenceIntegrityListener
#    uploadable:
#        default_file_path:           "%kernel.project_dir%/public/uploads"
#        mime_type_guesser_class:     Stof\DoctrineExtensionsBundle\Uploadable\MimeTypeGuesserAdapter
#        default_file_info_class:     Stof\DoctrineExtensionsBundle\Uploadable\UploadedFileInfo
#        validate_writable_directory: true
