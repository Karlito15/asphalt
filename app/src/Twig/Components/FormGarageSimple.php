<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormGarageSimple',
    template: '@App/components/form-garage-simple.html.twig',
)]
final class FormGarageSimple
{
    public FormView $form;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setIgnoreUndefined('maxValue')
            ->setRequired('form')
            ->setAllowedTypes('form', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
