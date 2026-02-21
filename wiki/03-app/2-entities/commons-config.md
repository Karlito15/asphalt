## **ID**
``` php
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\Type(type: ['integer', 'null'], message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index'])]
    private ?int $id = null;
```

## **Slug**
``` php
    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 128)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Groups(['index'])]
    private string $slug;
```

## **Event**
``` php

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var SettingUnitPrice $object */
        $object = $args->getObject();
        if ($object instanceof SettingUnitPrice) {
            // Set Slug
            $object->setSlug();
        }
    }
```
