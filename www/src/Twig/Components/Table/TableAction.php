<?php

namespace App\Twig\Components\Table;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'TableAction',
    template: '@App/components/table/Action.html.twig',
)]
final class TableAction
{
    /**
     * @var int
     */
    private int $id = 0;

    /**
     * @var string
     */
    private string $link = '';


    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('id')->setAllowedTypes('id', 'integer');
        $resolver->setRequired('link')->setAllowedTypes('link', 'string');

        return $resolver->resolve($data);
    }
}
