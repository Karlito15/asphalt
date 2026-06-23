<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormControl',
    template: '@App/themes/lte/components/form/control.html.twig',
)]
final class FormControl
{
}
