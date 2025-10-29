<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormGroup3Values',
    template: '@App/components/form-group-3-values.html.twig',
)]
final class FormGroup3Values
{
}
