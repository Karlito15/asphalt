<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\InventoryAppRepository;
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

#[ORM\Entity(repositoryClass: InventoryAppRepository::class)]
#[ORM\Table(name: 'inventory_app')]
#[ORM\Index(name: 'inventory_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['label', 'value', 'filter', 'position'])]
#[UniqueEntity(fields: ['slug'])]
class InventoryApp
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity, SlugEntity;

    #[ORM\Column(type: Types::STRING, length: 16, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 16)]
    #[Groups(['api'])]
    protected string $category;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 3, max: 32)]
    #[Groups(['api'])]
    protected string $label;

    #[ORM\Column(type: Types::STRING, length: 32, nullable: false, options: ["default" => '---'])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 1, max: 32)]
    #[Groups(['api'])]
    protected string $filter = '---';

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Groups(['api'])]
    protected ?int $position = null;

    #[ORM\Column(nullable: false, options: ["default" => 0, 'unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Groups(['api'])]
    protected int $value = 0;

    #[ORM\Column]
    #[Assert\Type(type: ['boolean'])]
    #[Groups(['api'])]
    protected ?bool $active = null;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: true)]
    #[Assert\Length(min: 3, max: 128)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type(type: 'string', message: 'The value {{ value }} is not a valid {{ type }}.')]
    #[Gedmo\Slug(fields: ['label', 'filter'], separator: '-')]
    #[Groups(['api'])]
    protected ?string $slug = null;

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
}
