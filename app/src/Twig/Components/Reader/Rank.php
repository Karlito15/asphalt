<?php

declare(strict_types=1);

namespace App\Twig\Components\Reader;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ReaderRank',
    template: '@App/themes/lte/components/reader/rank.html.twig',
)]
final class Rank
{
}
