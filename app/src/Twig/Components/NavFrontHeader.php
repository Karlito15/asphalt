<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'NavFrontHeader',
    template: '@App/components/nav-front-header.html.twig',
)]
final class NavFrontHeader
{
    private string $icon    = 'fa-house';

    private string $link    = 'javascript:void(0);';

    private string $text    = 'My Link';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['icon', 'link', 'text'])
            ->setAllowedTypes('icon', 'string')
            ->setAllowedTypes('link', 'string')
            ->setAllowedTypes('text', 'string')
        ;

        return $resolver->resolve($data);
    }
}
