<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\SettingTagRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingTagRepository::class)]
#[ORM\Table(name: 'setting_tag')]
#[ORM\Index(name: 'setting_tag_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class SettingTag
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(nullable: true, options: ['unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Assert\Type(type: ['integer'])]
    #[Groups(['index'])]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type('string')]
    #[Assert\Unique]
    #[Groups(['index', 'migration'])]
    protected string $value;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 199)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index'])]
    protected int $carsNumber = 0;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Unique]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getId(): ?int
    {
        return $this->id;
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
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
