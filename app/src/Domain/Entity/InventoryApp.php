<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\InventoryAppRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InventoryAppRepository::class)]
#[ORM\Table(name: 'inventory_app')]
#[ORM\Index(name: 'inventory_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class InventoryApp
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

    #[ORM\Column(type: Types::STRING, length: 16, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected string $category;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected string $label;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false)]
    #[Groups(['index', 'migration'])]
    protected string $filter = '---';

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected ?int $position = null;

    #[ORM\Column(nullable: false, options: ['unsigned' => true])]
    #[Groups(['index', 'migration'])]
    protected int $value = 0;

    #[ORM\Column(nullable: false)]
    #[Groups(['index', 'migration'])]
    protected bool $active = true;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: true)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string')]
    #[Gedmo\Slug(fields: ['label', 'filter'], separator: '-')]
    #[Groups(['index', 'migration'])]
    protected ?string $slug = null;

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

    public function isActive(): bool
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
