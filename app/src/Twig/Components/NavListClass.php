<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'NavListClass',
    template: '@App/components/nav-list-class.html.twig',
)]
final class NavListClass
{
    public string $link = 'javascript:void(0);';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');

        return $resolver->resolve($data);
    }
}
