<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\StatisticalGarageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: StatisticalGarageRepository::class)]
#[ORM\Table(name: 'statistical_garage')]
#[ORM\Index(name: 'statistical_garage_idx', columns: ['slug'])]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class StatisticalGarage
{
    use TimestampableEntity, SoftDeleteableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    private string $name;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $value = null;

    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Gedmo\Slug(fields: ['name'], separator: '-')]
    protected string $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setValue(?array $value): static
    {
        $this->value = $value;

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
