<?php

namespace App\Entity;

use App\Repository\AppInventoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppInventoryRepository::class)]
#[ORM\Table(name: 'app_inventory')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['label', 'value', 'filter', 'position'])]
#[UniqueEntity(fields: ['slug'])]
class AppInventory
{
    /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['unsigned' => true])]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 16, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 16)]
    #[Gedmo\Versioned]
    private string $category;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 32)]
    #[Gedmo\Versioned]
    private string $label;

    #[ORM\Column(nullable: false, options: ["default" => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Gedmo\Versioned]
    private int $value = 0;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false, options: ["default" => '---'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 32)]
    #[Gedmo\Versioned]
    private string $filter = '---';

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $position = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['label', 'filter'], separator: '-')]
    #[Gedmo\Versioned]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getFilter(): ?string
    {
        return $this->filter;
    }

    public function setFilter(string $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

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
