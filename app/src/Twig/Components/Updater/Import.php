<?php

declare(strict_types=1);

namespace App\Twig\Components\Updater;

use App\Domain\Entity\InventoryApp;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'UpdaterImport',
    template: '@App/themes/lte/components/updater/import.html.twig',
)]
final class Import
{
    public int $maxValue;

    public string|null $letter;

    public string|null $icon;

    public InventoryApp $entity;

    public function getMaxValue(): int
    {
        return $this->maxValue;
    }

    public function getLetter(): ?string
    {
        return '<i class="fa-solid ' . $this->letter . ' fa-2x"></i>';
    }

    public function getIcon(): string
    {
        ### default icon
        if (is_null($this->icon)) {
            return '<i class="fa-solid fa-diamond fa-2x"></i>';
        }

        return '<i class="fa-solid ' . $this->icon . ' fa-2x"></i>';
    }

    public function getId(): int
    {
        return $this->entity->getId();
    }

    public function getLabel(): string
    {
        return $this->entity->getLabel();
    }

    public function getValue(): int
    {
        return $this->entity->getValue();
    }

    public function getPosition(): int
    {
        return $this->entity->getPosition();
    }

    public function getSlug(): string
    {
        return $this->entity->getSlug();
    }

    public function getPercent(): float
    {
        return round(($this->getValue() / $this->getMaxValue()) * 100);
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
            ### Autorise extras HTML
            ->setIgnoreUndefined(false)

            ### Required
            ->setRequired(['maxValue', 'entity'])

            ### Default
            ->setDefault('maxValue', 0)
            ->setDefault('letter', null)
            ->setDefault('icon', null)

            ### Types Allowed
            ->setAllowedTypes('maxValue', 'int')
            ->setAllowedTypes('letter', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
        ;

        return $resolver->resolve($data);
    }
}
