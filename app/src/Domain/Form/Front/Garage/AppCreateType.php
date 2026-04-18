<?php

declare(strict_types=1);

namespace App\Domain\Form\Front\Garage;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Domain\Service\Type\DefaultType;
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
            ### Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => self::attrClass(),
                    'placeholder'   => 'text.model',
                ],
                'label'         => 'text.model',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete'  => 'off',
                    'class'         => self::attrClass(),
                    'min'           => 1,
                ],
                'label'     => 'text.game.update',
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
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
            ### Settings
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
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
                    'class' => self::attrClass(),
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
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
