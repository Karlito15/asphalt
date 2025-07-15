<?php

namespace App\Twig\Components\Button;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'ButtonDelete',
    template: '@App/components/button/Delete.html.twig',
)]
final class ButtonDelete
{
}
