<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\GarageStatActual;
use App\Domain\Entity\GarageStatMax;
use App\Domain\Entity\GarageStatMin;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterStat',
    template: '@App/themes/lte/components/updater/stat.html.twig',
)]
final class Stat
{
    public GarageStatActual|GarageStatMax|GarageStatMin $entity;

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
            ->setAllowedTypes('entity', [GarageStatActual::class, GarageStatMax::class, GarageStatMin::class])
            ->setAllowedTypes('formulaire', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
