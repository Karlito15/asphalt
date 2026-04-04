<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageApp;
use App\Persistence\Entity\SettingBrand;
use App\Persistence\Entity\SettingClass;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppCreateType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => 'fw-bold',
                    'placeholder'   => 'text.model',
                ],
                'label'         => 'text.model',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete'  => 'off',
                    'class'         => 'fw-bold',
                    'min'           => 1,
                ],
                'label'     => 'text.game.update',
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
                'choices'       => [
                    'text.3' => 3,
                    'text.4' => 4,
                    'text.5' => 5,
                    'text.6' => 6,
                ],
                'label'         => 'text.stars',
                'placeholder'   => 'text.stars',
                'required'      => true,
                'trim'          => true,
            ])
            // Settings
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
                // 'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'empty_data'    => null,
                'label'         => 'text.setting.brand',
                'placeholder'   => 'text.setting.brand',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('settingClass', EntityType::class, [
                'attr'          => [
                    'class' => 'fw-bold',
                ],
                'choice_label'  => 'value',
                'class'         => SettingClass::class,
                'empty_data'    => null,
                'label'         => 'text.setting.class',
                'placeholder'   => 'text.setting.class',
                'required'      => true,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageApp::class,
            'allow_extra_fields' => false, // true
            'translation_domain' => 'messages',
        ]);
    }
}
