<?php

declare(strict_types=1);

namespace App\Twig\Components;

use App\Domain\Entity\InventoryApp;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\{AsTwigComponent, PreMount};

#[AsTwigComponent(
    name: 'FormDashboardImport',
    template: '@App/themes/lte/components/form/dashboard-import.html.twig',
)]
final class FormDashboardImport
{
    public int $maxValue;

    public string|null $letter;

    public string|null $icon;

    public InventoryApp $entity;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver
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

    public function getLetter(): string
    {
        return '<i class="fa-solid ' . $this->letter . ' fa-1x"></i>';
    }

    public function getIcon(): string
    {
        return $this->icon;
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
}
