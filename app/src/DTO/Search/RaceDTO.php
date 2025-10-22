<?php

declare(strict_types=1);

namespace App\DTO\Search;

use App\Entity\RaceMode;
use App\Entity\RaceRegion;
use App\Entity\RaceSeason;
use App\Entity\RaceTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class RaceDTO
{
    /** @var RaceMode|null */
    public ?RaceMode $mode = null;

    /** @var RaceRegion|null */
    public ?RaceRegion $region = null;

    /** @var RaceSeason|null */
    public ?RaceSeason $season = null;

    /** @var RaceTime|null */
    public ?RaceTime $time = null;

    /** @var int|null */
    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\PositiveOrZero]
    #[Assert\Range(min: 0, max: 30)]
    public ?int $raceOrder = null;

    /** @var bool|null */
    public ?bool $finished = null;
}
