<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageApp;
use App\Entity\SettingBrand;
use App\Entity\SettingClass;
use App\Trait\Form\FormTrait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppCreateType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => 'fw-bold',
                    'placeholder'   => 'form.model',
                ],
                'label'         => 'form.model',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete'  => 'off',
                    'class'         => 'fw-bold',
                    'min'           => 1,
                ],
                'label'     => 'form.gameUpdate',
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
                'choices'       => [
                    'form.3' => 3,
                    'form.4' => 4,
                    'form.5' => 5,
                    'form.6' => 6,
                ],
                'label'         => 'form.stars',
                'placeholder'   => 'form.stars',
                'required'      => true,
                'trim'          => true,
            ])
            // Settings
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
//                'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'empty_data'    => null,
                'label'         => 'form.settingBrand',
                'placeholder'   => 'form.settingBrand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
//                'autocomplete'  => false,
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'empty_data'    => null,
                'label'         => 'form.settingClass',
                'placeholder'   => 'form.settingClass',
                'required'      => true,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageApp::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
