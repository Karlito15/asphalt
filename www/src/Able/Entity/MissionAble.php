<?php

declare(strict_types=1);

namespace App\Able\Entity;

use App\Entity\MissionApp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait MissionAble
{
    #[ORM\Column(type: Types::STRING, length: 64, unique:true, nullable:false)]
    #[Assert\Length(min: 1, max: 64)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private string $value;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable:false)]
    #[Gedmo\Slug(fields: ['value'], separator: '-')]
    #[Gedmo\Versioned]
    protected string $slug;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, MissionApp>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }
}
