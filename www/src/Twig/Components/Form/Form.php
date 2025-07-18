<?php

namespace App\Twig\Components\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'Form',
    template: '@App/components/form/Form.html.twig',
)]
final class Form
{
    /** @var mixed|null */
    private mixed $form = null;

    /** @var string */
    private string $link = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setRequired(['form', 'link'])
            ->setAllowedTypes('link', 'string')
        ;

        return $resolver->resolve($data);
    }
}
