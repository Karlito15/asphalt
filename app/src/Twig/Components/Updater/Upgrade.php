<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\GarageUpgrade;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterUpgrade',
    template: '@App/themes/lte/components/updater/upgrade.html.twig',
)]
final class Upgrade
{
    public int $maxValue;

    public string|null $title;

    public string|null $icon;

    public GarageUpgrade $entity;

    public FormView $formulaire;

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
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
            ->setRequired(['maxValue', 'title', 'icon', 'entity', 'formulaire'])

            ### Default
            ->setDefault('maxValue', 0)
            ->setDefault('title', null)
            ->setDefault('icon', null)
            ->setDefault('formulaire', null)

            ### Types Allowed
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('title', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setAllowedTypes('entity', GarageUpgrade::class)
            ->setAllowedTypes('formulaire', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
