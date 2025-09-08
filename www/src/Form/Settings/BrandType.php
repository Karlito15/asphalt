<?php

namespace App\Form\Settings;

use App\Entity\SettingBrand;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'max'          => 64,
                ],
                'label'    => 'form.setting.brand.name',
                'required' => true,
                'trim'     => true,
            ])
            ->add('cars_number', NumberType::class, [
                'label'    => 'form.setting.brand.cars_number',
                'required' => false,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => SettingBrand::class,
            'translation_domain' => 'forms',
        ]);
    }
}
