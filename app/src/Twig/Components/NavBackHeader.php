<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'NavBackHeader',
    template: '@App/components/nav-back-header.html.twig',
)]
final class NavBackHeader
{
    private string $path    = 'javascript:void(0);';

    private string $route   = 'app.dashboard.noLocale';

    private string $text    = 'My Link';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('route')->setAllowedTypes('route', 'string');
        $resolver->setRequired('path')->setAllowedTypes('path', 'string');
        $resolver->setRequired('text')->setAllowedTypes('text', 'string');

        return $resolver->resolve($data);
    }
}
