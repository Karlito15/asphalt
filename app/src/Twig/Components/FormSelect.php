<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'FormSelect',
    template: '@App/components/form/select.html.twig',
)]
final class FormSelect
{
}
