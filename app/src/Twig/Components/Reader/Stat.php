<?php

declare(strict_types=1);

namespace App\Twig\Components\Reader;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ReaderStat',
    template: '@App/themes/lte/components/reader/stat.html.twig',
)]
final class Stat
{
}
