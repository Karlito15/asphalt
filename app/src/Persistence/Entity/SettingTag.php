<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\SettingTagRepository;
use App\Toolbox\Trait\Entity\IdEntity;
use App\Toolbox\Trait\Entity\SlugEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingTagRepository::class)]
#[ORM\Table(name: 'setting_tag')]
#[ORM\Index(name: 'setting_tag_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['value'])]
class SettingTag
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 64, nullable: false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration'])]
    protected string $value;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 999)]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Groups(['index', 'migration'])]
    protected int $carsNumber = 0;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 3, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getCarsNumber(): ?int
    {
        return $this->carsNumber;
    }

    public function setCarsNumber(int $carsNumber): static
    {
        $this->carsNumber = $carsNumber;

        return $this;
    }
}
