<?php

declare(strict_types=1);

namespace App\Application\Service\Command;

trait AllCommand
{
    use ConfigureCommand;
    use InitializeCommand;
    use InteractCommand;
    use ResumeCommand;
}
