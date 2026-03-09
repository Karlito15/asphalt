<?php

declare(strict_types=1);

namespace App\Persistence\Entity;

use App\Persistence\Repository\RaceAppRepository;
use App\Toolbox\Trait\Entity\IdEntity;
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

#[ORM\Entity(repositoryClass: RaceAppRepository::class)]
#[ORM\Table(name: 'race_app')]
#[ORM\Index(name: 'race_app_idx', columns: ['slug'])]
#[ORM\HasLifecycleCallbacks]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false, hardDelete: true)]
#[UniqueEntity(fields: ['slug'])]
class RaceApp
{
    /**
     * Hook Timestamp behavior updates createdAt, updatedAt fields
     * Hook SoftDeleteable behavior updates deletedAt field.
     */
    use TimestampableEntity;
    use SoftDeleteableEntity;
    use IdEntity;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['default' => 0, 'unsigned' => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['index'])]
    protected ?int $raceOrder = null;

    #[ORM\Column(nullable: false, options: ['default' => false])]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    protected bool $finished = false;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\Length(min: 1, max: 255)]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Groups(['index'])]
    protected string $slug;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "mode_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceMode::class)]
    #[Groups(['index'])]
    protected RaceMode $mode;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "season_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceSeason::class)]
    #[Groups(['index'])]
    protected RaceSeason $season;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "time_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceTime::class)]
    #[Groups(['index'])]
    protected RaceTime $time;

    #[ORM\ManyToOne(fetch: 'EAGER', inversedBy: 'race')]
    #[ORM\JoinColumn(name: "track_id", referencedColumnName: "id", unique: false, nullable: false)]
    #[Assert\Type(RaceTrack::class)]
    #[Groups(['index'])]
    protected RaceTrack $track;

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

    public function setSlug(): static
    {
        $slugger = new AsciiSlugger();

        /** @var RaceApp $this  */
        $this->slug = $slugger->slug(
            (string) $this->getSeason())->lower() . '-' .
            $slugger->slug((string) $this->getRaceOrder())->lower() . '-' .
            $slugger->slug((string) $this->getTrack())->lower()
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
        /* @var RaceApp $object */
        $object = $args->getObject();
        if ($object instanceof RaceApp) {
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
        /* @var RaceApp $object */
        $object = $args->getObject();
        if ($object instanceof RaceApp) {
            $object->setSlug();
        }
    }
}
