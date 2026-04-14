<?php

declare(strict_types=1);

namespace App\Application\DTO\Search;

use App\Domain\Entity\RaceMode;
use App\Domain\Entity\RaceRegion;
use App\Domain\Entity\RaceSeason;
use App\Domain\Entity\RaceTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class RaceDTO
{
    public ?RaceMode $mode     = null;

    public ?RaceRegion $region = null;

    public ?RaceSeason $season = null;

    public ?RaceTime $time     = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 30)]
    public ?int $raceOrder     = null;

    public ?bool $finished     = null;
}
