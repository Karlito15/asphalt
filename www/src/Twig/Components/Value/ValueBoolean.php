<?php

namespace App\Twig\Components\Value;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ValueBoolean',
    template: '@App/components/value/Boolean.html.twig',
)]
final class ValueBoolean
{
}
