<?php

declare(strict_types=1);

namespace App\Form\Back;

use App\Entity\SettingBrand;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingBrandType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'max' => 64,
                ],
                'label' => 'form.brand',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingBrand::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
