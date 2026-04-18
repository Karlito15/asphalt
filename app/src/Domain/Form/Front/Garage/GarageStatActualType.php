<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Garage;

use App\Domain\Entity\GarageStatActual;
use App\Domain\Service\Type\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatActualType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('handling', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => false,
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr'       => self::attrClass(),
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
            'data_class'  => GarageStatActual::class,
            'allow_extra_fields' => false,
            'translation_domain' => false,
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'text-end fw-bolder form-control-plaintext form-control-sm',
        ];
    }
}
