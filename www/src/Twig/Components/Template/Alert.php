<?php

namespace App\Twig\Components\Template;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'TemplateAlert',
    template: '@App/components/template/Alert.html.twig',
)]
final class Alert
{
}
