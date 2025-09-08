<?php

namespace App\Form\App;

use App\Able\FormAble;
use App\Entity\AppGarage;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageCreateType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /** Garage */
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => 'form-control-lg',
                    'placeholder'   => 'form.app.garage.model',
                ],
                'label'         => 'form.app.garage.model',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete' => 'off',
                    'class' => 'form-control-lg',
                    'min'   => 1,
                ],
                'label'     => 'form.app.garage.gameUpdate',
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => 'form-control-lg',
                ],
                'choices'       => [
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                ],
                'label'         => 'form.app.garage.stars',
                'placeholder'   => 'form.app.garage.stars',
                'required'      => true,
                'trim'          => true,
            ])
            /** Settings */
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control',
                ],
                'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'label'         => 'form.app.garage.settingBrand',
                'placeholder'   => 'form.app.garage.settingBrand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => 'form-control-lg',
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'label'         => 'form.app.garage.settingClass',
                'placeholder'   => 'form.app.garage.settingClass',
                'required'      => true,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => AppGarage::class,
            'translation_domain' => 'forms',
        ]);
    }
}
