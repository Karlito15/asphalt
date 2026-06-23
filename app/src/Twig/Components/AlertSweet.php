<?php

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'AlertSweet',
    template: '@App/themes/lte/components/alert/sweet.html.twig',
)]
final class AlertSweet
{
}
