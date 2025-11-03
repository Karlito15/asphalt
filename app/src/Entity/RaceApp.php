<?php

namespace App\Entity;

use App\Repository\RaceAppRepository;
use App\Trait\Entity\RaceAppTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RaceAppRepository::class)]
#[ORM\Table(name: 'race_app')]
#[ORM\Index(name: 'race_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['slug'])]
class RaceApp
{
     /**
     * Hook timestamp behavior
     * updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior
     * updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use RaceAppTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private ?int $raceOrder = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    #[Gedmo\Versioned]
    private bool $finished = false;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Gedmo\Versioned]
    private string $slug;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "mode_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceMode::class)]
    private RaceMode $mode;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "season_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceSeason::class)]
    private RaceSeason $season;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "time_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceTime::class)]
    private RaceTime $time;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "track_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceTrack::class)]
    private RaceTrack $track;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaceOrder(): ?int
    {
        return $this->raceOrder;
    }

    public function setRaceOrder(?int $raceOrder): static
    {
        $this->raceOrder = $raceOrder;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getMode(): ?RaceMode
    {
        return $this->mode;
    }

    public function setMode(?RaceMode $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getSeason(): ?RaceSeason
    {
        return $this->season;
    }

    public function setSeason(?RaceSeason $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getTime(): ?RaceTime
    {
        return $this->time;
    }

    public function setTime(?RaceTime $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getTrack(): ?RaceTrack
    {
        return $this->track;
    }

    public function setTrack(?RaceTrack $track): static
    {
        $this->track = $track;

        return $this;
    }
}
