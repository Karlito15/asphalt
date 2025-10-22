<?php

namespace App\Form\Back;

use App\Entity\SettingLevel;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingLevelType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'max' => 13,
                    'min' => 0,
                 ],
                'label' => 'form.level',
                'required' => true,
                'trim' => true,
            ])
            ->add('common', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'max' => 36,
                    'min' => 0,
                 ],
                'label' => 'form.common',
                'required' => true,
                'trim' => true,
            ])
            ->add('rare', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'max' => 20,
                    'min' => 0,
                 ],
                'label' => 'form.rare',
                'required' => true,
                'trim' => true,
            ])
            ->add('epic', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'max' => 16,
                    'min' => 0,
                 ],
                'label' => 'form.epic',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingLevel::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
