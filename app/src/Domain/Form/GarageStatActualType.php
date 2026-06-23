<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageStatActual;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatActualType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('handling', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageStatActual::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',//messages
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @return array
     */
    private static function attrClassPrivate(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'black-ops-one-regular fs-5 text-end fw-bolder form-control-plaintext form-control-sm',
        ];
    }
}
