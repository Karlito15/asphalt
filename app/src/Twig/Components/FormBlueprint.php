<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormBlueprint',
    template: '@App/components/form/blueprint.html.twig',
)]
final class FormBlueprint
{
}
