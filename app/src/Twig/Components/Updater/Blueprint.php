<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\GarageBlueprint;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterBlueprint',
    template: '@App/themes/lte/components/updater/blueprint.html.twig',
)]
final class Blueprint
{
    public string|int $maxValue;

    public string|null $title;

    public GarageBlueprint $entity;

    public FormView $formulaire;

    public function getMaxValue(): int
    {
        return ($this->maxValue === 'Key') ? 1 : (int) $this->maxValue;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getValue(): int
    {
        return ($this->formulaire->vars['value'] === 'Key') ? 1 : (int) $this->formulaire->vars['value'];
    }

    public function getRest(): int
    {
        return ($this->getMaxValue() - $this->getValue());
    }

    public function getClass(): string
    {
        $result = $this->getRest();
        return match (true) {
            $result === $this->getMaxValue() => ' bg-danger-subtle text-danger',
            $result > 0                      => ' bg-primary-subtle text-primary',
            $result === 0                    => ' bg-success-subtle text-success',
        };
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
            ->setAllowedTypes('maxValue', ['int', 'string'])
            ->setAllowedTypes('title', ['null', 'string'])
            ->setAllowedTypes('entity', GarageBlueprint::class)
            ->setAllowedTypes('formulaire', FormView::class)
        ;

        return $resolver->resolve($data);
    }
}
