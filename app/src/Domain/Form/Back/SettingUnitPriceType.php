<?php

declare(strict_types=1);

namespace App\Domain\Form\Back;

use App\Domain\Entity\SettingUnitPrice;
use App\Domain\Service\Type\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingUnitPriceType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level01', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level01',
                'required' => true,
                'trim' => true,
            ])
            ->add('level02', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level02',
                'required' => true,
                'trim' => true,
            ])
            ->add('level03', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level03',
                'required' => true,
                'trim' => true,
            ])
            ->add('level04', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level04',
                'required' => true,
                'trim' => true,
            ])
            ->add('level05', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level05',
                'required' => true,
                'trim' => true,
            ])
            ->add('level06', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level06',
                'required' => true,
                'trim' => true,
            ])
            ->add('level07', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level07',
                'required' => true,
                'trim' => true,
            ])
            ->add('level08', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level08',
                'required' => true,
                'trim' => true,
            ])
            ->add('level09', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level09',
                'required' => true,
                'trim' => true,
            ])
            ->add('level10', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level10',
                'required' => true,
                'trim' => true,
            ])
            ->add('level11', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level11',
                'required' => true,
                'trim' => true,
            ])
            ->add('level12', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level12',
                'required' => true,
                'trim' => true,
            ])
            ->add('level13', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.level13',
                'required' => true,
                'trim' => true,
            ])
            ->add('common', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.common',
                'required' => true,
                'trim' => true,
            ])
            ->add('rare', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.rare',
                'required' => true,
                'trim' => true,
            ])
            ->add('epic', IntegerType::class, [
                 'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label' => 'text.epic',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SettingUnitPrice::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
