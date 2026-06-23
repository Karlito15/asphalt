<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Cron\Statistical;

use Doctrine\ORM\EntityManagerInterface;

final readonly class Race
{
    public function __construct(
        private EntityManagerInterface $manager,
    )
    {}
}
