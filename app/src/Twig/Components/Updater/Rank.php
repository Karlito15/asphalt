<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\GarageRank;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterRank',
    template: '@App/themes/lte/components/updater/rank.html.twig',
)]
final class Rank
{
    public int $maxValue;

    public string|null $title;

    public GarageRank $entity;

    public FormView $formulaire;

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getId(): int
    {
        return $this->entity->getId();
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['maxValue', 'title', 'entity', 'formulaire'])

            ### Default
            ->setDefault('maxValue', 0)
            ->setDefault('title', null)
            ->setDefault('formulaire', null)

            ### Types Allowed
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('title', ['null', 'string'])
            ->setAllowedTypes('entity', GarageRank::class)
            ->setAllowedTypes('formulaire', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
