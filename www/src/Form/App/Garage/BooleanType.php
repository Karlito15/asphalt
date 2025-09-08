<?php

namespace App\Form\App\Garage;

use App\Entity\GarageBoolean;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BooleanType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('locked', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.locked',
                'required'   => false,
            ])
            ->add('fullBlueprint', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_blueprint',
                'required'   => false,
            ])
            ->add('gold', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.gold',
                'required'   => false,
            ])
            ->add('to_unlock', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.to_unlock',
                'required'   => false,
            ])
            ->add('to_upgrade', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.to_upgrade',
                'required'   => false,
            ])
            ->add('to_gold', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.to_gold',
                'required'   => false,
            ])
            ->add('install_speed', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.speed',
                'required'   => false,
            ])
            ->add('full_speed', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_speed',
                'required'   => false,
            ])
            ->add('install_acceleration', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.acceleration',
                'required'   => false,
            ])
            ->add('full_acceleration', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_acceleration',
                'required'   => false,
            ])
            ->add('install_handly', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.handly',
                'required'   => false,
            ])
            ->add('full_handly', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_handly',
                'required'   => false,
            ])
            ->add('install_nitro', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.nitro',
                'required'   => false,
            ])
            ->add('full_nitro', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_nitro',
                'required'   => false,
            ])
            ->add('install_common', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.commons',
                'required'   => false,
            ])
            ->add('full_common', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_commons',
                'required'   => false,
            ])
            ->add('install_rare', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.rares',
                'required'   => false,
            ])
            ->add('full_rare', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_rares',
                'required'   => false,
            ])
            ->add('install_epic', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.epics',
                'required'   => false,
            ])
            ->add('full_epic', CheckboxType::class, [
                'attr' => [
                    'class' => 'btn-check'
                ],
                'label'      => 'form.app.garage.full_epics',
                'required'   => false,
            ])
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => GarageBoolean::class,
            'translation_domain' => 'forms',
        ]);
    }
}
