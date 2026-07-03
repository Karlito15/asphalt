<?php

declare(strict_types=1);

namespace App\Twig\Components\Reader;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ReaderBlueprint',
    template: '@App/themes/lte/components/reader/blueprint.html.twig',
)]
final class Blueprint
{
}
