<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormGroup2',
    template: '@App/components/form/group-2.html.twig',
)]
final class FormGroup2
{
}
