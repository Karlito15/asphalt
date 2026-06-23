<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\SettingLevelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SettingLevelRepository::class)]
#[ORM\Table(name: 'setting_level')]
#[ORM\Index(name: 'setting_level_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
class SettingLevel
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

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 10, max: 13)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $level = 10;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 36)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $common = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 20)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $rare = 0;

    #[ORM\Column(type: Types::SMALLINT, nullable: false, options: ['unsigned' => true])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 16)]
    #[Assert\Type(type: 'integer')]
    #[Groups(['index', 'migration'])]
    protected int $epic = 0;

    #[ORM\Column(type: Types::STRING, length: 128, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 128)]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Type(type: 'string')]
    #[Assert\Unique]
    #[Groups(['index', 'migration'])]
    protected string $slug;

    #[ORM\OneToMany(targetEntity: GarageApp::class, mappedBy: 'settingLevel')]
    protected Collection $garage;

    public function __construct()
    {
        $this->garage = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getCommon(): ?int
    {
        return $this->common;
    }

    public function setCommon(int $common): static
    {
        $this->common = $common;

        return $this;
    }

    public function getRare(): ?int
    {
        return $this->rare;
    }

    public function setRare(int $rare): static
    {
        $this->rare = $rare;

        return $this;
    }

    public function getEpic(): ?int
    {
        return $this->epic;
    }

    public function setEpic(int $epic): static
    {
        $this->epic = $epic;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(): static
    {
        $this->slug =
            str_pad((string) $this->level, 2, '0', STR_PAD_LEFT) . '|' .
            str_pad((string) $this->common, 2, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->rare, 2, '0', STR_PAD_LEFT) . '-' .
            str_pad((string) $this->epic, 2, '0', STR_PAD_LEFT)
        ;

        return $this;
    }

    /**
     * @return Collection<int, GarageApp>
     */
    public function getGarage(): Collection
    {
        return $this->garage;
    }

    public function addGarage(GarageApp $garage): static
    {
        if (!$this->garage->contains($garage)) {
            $this->garage->add($garage);
            $garage->setSettingLevel($this);
        }

        return $this;
    }

    public function removeGarage(GarageApp $garage): static
    {
        if ($this->garage->removeElement($garage)) {
            // set the owning side to null (unless already changed)
            if ($garage->getSettingLevel() === $this) {
                $garage->setSettingLevel(null);
            }
        }

        return $this;
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        $args->getObject()->setSlug();
    }
}
