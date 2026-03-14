<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'AlertSweet',
    template: '@App/components/alert/sweet.html.twig',
)]
final class AlertSweet
{
}
