<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormGroup2Values',
    template: '@App/components/form-group-2-values.html.twig',
)]
final class FormGroup2Values
{
}
