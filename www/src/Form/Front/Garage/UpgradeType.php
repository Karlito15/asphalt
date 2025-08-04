<?php

namespace App\Form\Front\Garage;

use App\Able\Form\FormAble;
use App\Entity\GarageUpgrade;
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
                    'class'        => 'text-center fw-bolder',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'form.speed',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('acceleration', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'form.acceleration',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('handling', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'form.handling',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('nitro', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 13,
                    'min'          => 0,
                ],
                'label'      => 'form.nitro',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('common', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 36,
                    'min'          => 0,
                ],
                'label'      => 'form.common',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('rare', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 20,
                    'min'          => 0,
                ],
                'label'      => 'form.rare',
                'label_attr' => [
                    'class' => 'm-0',
                ],
                'required'   => false,
            ])
            ->add('epic', IntegerType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                    'max'          => 16,
                    'min'          => 0,
                ],
                'label'      => 'form.epic',
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
            'data_class' => GarageUpgrade::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
