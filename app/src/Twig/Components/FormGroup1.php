<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormGroup1',
    template: '@App/components/form/group-1.html.twig',
)]
final class FormGroup1
{
}
