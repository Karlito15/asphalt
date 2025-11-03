<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableAction',
    template: '@App/components/table-action.html.twig',
)]
final class TableAction
{
    /** @var int $id ID of Entity */
    private int $id = 0;

    /** @var null $slug Slug of Entity */
    private null $slug = null;

    /** @var string $link Link of Update */
    private string $link = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired('id')
            ->setAllowedTypes('id', 'integer')
        ;
        $resolver
            ->setRequired('link')
            ->setAllowedTypes('link', 'string')
        ;
        $resolver
            ->setIgnoreUndefined('slug')
        ;

        return $resolver->resolve($data);
    }
}
