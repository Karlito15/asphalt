<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormCheckbox',
    template: '@App/themes/lte/components/form/checkbox.html.twig',
)]
final class FormCheckbox
{
}
