<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormGroup1Value',
    template: '@App/components/form-group-1-values.html.twig',
)]
final class FormGroup1Value
{
}
