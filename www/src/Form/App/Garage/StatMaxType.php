<?php

namespace App\Form\App\Garage;

use App\Entity\GarageStatMax;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatMaxType extends AbstractType
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
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'scale'    => 2,
                'required' => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Acceleration',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'scale'    => 2,
                'required' => false,
            ])
            ->add('handly', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Handly',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'scale'    => 2,
                'required' => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                ],
                'label'    => 'Nitro',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'scale'    => 2,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => GarageStatMax::class,
            'translation_domain' => 'forms',
        ]);
    }
}
