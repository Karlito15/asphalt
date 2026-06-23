<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageApp;
use App\Domain\Entity\SettingBrand;
use App\Domain\Entity\SettingClass;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageAppCreateType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ### Garage
            ->add('model', TextType::class, [
                'attr'          => [
                    'autocomplete'  => 'off',
                    'class'         => self::attrClass(),
                    'placeholder'   => 'form.model',
                ],
                'label'         => 'form.model',
                'required'      => true,
                'trim'          => true,
            ])
            ->add('gameUpdate', IntegerType::class, [
                'attr'      => [
                    'autocomplete'  => 'off',
                    'class'         => self::attrClass(),
                    'min'           => 1,
                ],
                'label'     => 'form.game.update',
                'required'  => true,
                'trim'      => true,
            ])
            ->add('stars', ChoiceType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
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
            ### Settings
            ->add('settingBrand', EntityType::class, [
                'attr'          => [
                    'class' => self::attrClass(),
                ],
                // 'autocomplete'  => true,
                'choice_label'  => 'name',
                'class'         => SettingBrand::class,
                'empty_data'    => null,
                'label'         => 'form.brand',
                'placeholder'   => 'form.brand',
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
                'label'         => 'form.class',
                'placeholder'   => 'form.class',
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
            'translation_domain' => 'forms',//messages
        ]);
    }
}
