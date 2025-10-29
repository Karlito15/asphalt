<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'InputGroup2Values',
    template: '@App/components/input-group-2-values.html.twig',
)]
final class InputGroup2Values
{
}
