<?php

namespace App\Form\App\Garage;

use App\Entity\GarageUpgrade;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpgradeType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'Speed',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('acceleration', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'Acceleration',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('handly', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'Handly',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('nitro', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'Nitro',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('common', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 36,
                    'min'          => 0,
                ],
                'label'      => 'Common',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('rare', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 20,
                    'min'          => 0,
                ],
                'label'      => 'Rare',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('epic', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center',
                    'max'          => 16,
                    'min'          => 0,
                ],
                'label'      => 'Epic',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => GarageUpgrade::class,
            'translation_domain' => 'forms',
        ]);
    }
}
