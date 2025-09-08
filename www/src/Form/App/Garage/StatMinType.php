<?php

namespace App\Form\App\Garage;

use App\Entity\GarageStatMin;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatMinType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Speed',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Acceleration',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('handly', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Handly',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Nitro',
                'scale'    => 2,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => GarageStatMin::class,
            'translation_domain' => 'forms',
        ]);
    }
}
