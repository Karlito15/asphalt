<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'NavBackFooter',
    template: '@App/components/nav-back-footer.html.twig',
)]
final class NavBackFooter
{
    /** @var array */
    private array $links = [];

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('links')
            ->setAllowedTypes('links', 'array[]')
        ;

        return $resolver->resolve($data);
    }
}
