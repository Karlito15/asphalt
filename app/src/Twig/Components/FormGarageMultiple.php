<?php

namespace App\Twig\Components;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'FormGarageMultiple',
    template: '@App/components/form-garage-multiple.html.twig',
)]
final class FormGarageMultiple
{
    public FormView $form;

    public int $classNumber = 199;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ->setIgnoreUndefined('form')
            ->setRequired('classNumber')
            ->setAllowedTypes('classNumber', 'int')
        ;

        return $resolver->resolve($data);
    }
}
