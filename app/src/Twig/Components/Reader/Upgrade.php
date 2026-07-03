<?php

declare(strict_types=1);

namespace App\Twig\Components\Reader;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ReaderUpgrade',
    template: '@App/themes/lte/components/reader/upgrade.html.twig',
)]
final class Upgrade
{
}
