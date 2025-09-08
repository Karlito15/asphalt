<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'SidebarSubLevel',
    template: '@App/components/SidebarSubLevel.html.twig'
)]
final class SidebarSubLevel
{
    public string $link     = 'javascript:void(0);';

    public string $title    = 'My Link';

    public string $drop     = 'filter';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');
        $resolver->setRequired('title')->setAllowedTypes('title', 'string');
        $resolver->setRequired('drop')->setAllowedTypes('drop', 'string');

        return $resolver->resolve($data);
    }
}
