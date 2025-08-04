<?php

namespace App\Twig\Components\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormGarageRead',
    template: '@App/components/Form/GarageRead.html.twig',
)]
final class GarageRead
{
    /** @var mixed */
    private mixed $value = null;

    /** @var string|null */
    private string|null $name = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['name', 'value'])
            ->setAllowedTypes('name', ['null', 'string'])
            ->setAllowedTypes('value', ['null', 'string', 'int'])
        ;

        return $resolver->resolve($data);
    }
}
