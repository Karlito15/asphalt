<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageStatus;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatusType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('unblock', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.unblock',
            'required'      => false,
        ])
            ->add('gold', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.gold',
            'required'      => false,
        ])
            ->add('evo', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.evo',
            'required'      => false,
        ])
            ->add('eventClass', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.event.class',
            'required'      => false,
        ])
            ->add('toUpgrade', CheckboxType::class, [
            'attr'          => self::attrClass(),
            'label'         => 'text.to.upgrade',
            'required'      => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatus::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'class' => 'form-check-input'
        ];
    }
}
