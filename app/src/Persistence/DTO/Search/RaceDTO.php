<?php

declare(strict_types=1);

namespace App\Persistence\DTO\Search;

use App\Persistence\Entity\RaceMode;
use App\Persistence\Entity\RaceRegion;
use App\Persistence\Entity\RaceSeason;
use App\Persistence\Entity\RaceTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class RaceDTO
{
    public ?RaceMode $mode = null;

    public ?RaceRegion $region = null;

    public ?RaceSeason $season = null;

    public ?RaceTime $time = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 30)]
    public ?int $raceOrder = null;

    public ?bool $finished = null;
}
