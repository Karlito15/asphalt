<?php

namespace App\DTO;

use App\Entity\RaceMode;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class SearchRaceDTO
{
    /** @var RaceMode|null */
    public ?RaceMode $mode     = null;

    /** @var RaceSeason|null */
    public ?RaceSeason $season = null;

    /** @var RaceTime|null */
    public ?RaceTime $time     = null;

    /** @var int|null */
    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 25)]
    public ?int $raceOrder     = null;

    /** @var bool|null */
    public ?bool $finished     = null;

    public function getMode(): ?RaceMode
    {
        return $this->mode;
    }

    public function setMode(RaceMode $mode): void
    {
        $this->mode = $mode;
    }

    public function getSeason(): ?RaceSeason
    {
        return $this->season;
    }

    public function setSeason(RaceSeason $season): void
    {
        $this->season = $season;
    }

    public function getTime(): ?RaceTime
    {
        return $this->time;
    }

    public function setTime(RaceTime $time): void
    {
        $this->time = $time;
    }

    public function getRaceOrder(): ?int
    {
        return $this->raceOrder;
    }

    public function setRaceOrder(?int $raceOrder): SearchRaceDTO
    {
        $this->raceOrder = $raceOrder;
        return $this;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): void
    {
        $this->finished = $finished;
    }
}
