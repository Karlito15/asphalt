<?php

namespace App\Form\Front\Garage;

use App\Able\Form\FormAble;
use App\Entity\GarageStatMin;
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
                    'class'        => 'text-center fw-bolder',
                ],
                'label'    => 'form.speed',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                ],
                'label'    => 'form.acceleration',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('handling', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                ],
                'label'    => 'form.handling',
                'scale'    => 2,
                'required' => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => 'text-center fw-bolder',
                ],
                'label'    => 'form.nitro',
                'scale'    => 2,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageStatMin::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
