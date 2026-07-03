<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\GarageStatus;
use App\Domain\Entity\GarageStatusControl;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterCheckbox',
    template: '@App/themes/lte/components/updater/checkbox.html.twig',
)]
final class Checkbox
{
    public GarageStatus|GarageStatusControl $entity;

    public FormView $formulaire;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['entity', 'formulaire'])

            ### Default
            ->setDefault('formulaire', null)

            ### Types Allowed
            ->setAllowedTypes('entity', [GarageStatus::class, GarageStatusControl::class])
            ->setAllowedTypes('formulaire', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
