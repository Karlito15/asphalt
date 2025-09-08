<?php

namespace App\Entity;

use App\Repository\AppRaceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppRaceRepository::class)]
#[ORM\Table(name: 'app_race')]
#[ORM\Index(name: 'slug_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\Loggable]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['slug'])]
class AppRace
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
    #[Groups(['index'])]
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var AppRace $this  */
        $this->slug = $slugger->slug(
            $this->getSeason())->lower() . '-' .
            $slugger->slug($this->getTrack())->lower() . '-' .
            $slugger->slug($this->getRaceOrder())->lower()
        ;

        return $this;
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

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PrePersist]
    public function prePersist(LifecycleEventArgs $args): void
    {
        /* @var AppRace $object */
        $object = $args->getObject();
        if ($object instanceof AppRace) {
            $object->setSlug();
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    #[ORM\PreUpdate]
    public function preUpdate(LifecycleEventArgs $args): void
    {
        /* @var AppRace $object */
        $object = $args->getObject();
        if ($object instanceof AppRace) {
            $object->setSlug();
        }
    }
}
