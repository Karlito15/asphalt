<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormRange',
    template: '@App/themes/lte/components/form/range.html.twig',
)]
final class FormRange
{
}
