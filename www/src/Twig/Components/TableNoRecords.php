<?php

namespace App\Twig\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsLiveComponent(
    name: 'TableNoRecords',
    template: '@App/components/TableNoRecords.html.twig',
)]
final class TableNoRecords
{
    use DefaultActionTrait;

    /**
     * @var int number of column
     */
    public int $value = 6;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired('value')->setAllowedTypes('value', 'integer');

        return $resolver->resolve($data);
    }
}
