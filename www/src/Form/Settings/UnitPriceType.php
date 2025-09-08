<?php

namespace App\Form\Settings;

use App\Entity\SettingUnitPrice;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UnitPriceType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level01', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level01',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level02', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level02',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level03', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level03',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level04', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level04',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level05', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level05',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level06', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level06',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level07', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level07',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level08', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level08',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level09', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level09',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level10', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level10',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level11', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level11',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level12', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level12',
                'required' => true,
                'trim'     => true,
            ])
            ->add('level13', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.level13',
                'required' => true,
                'trim'     => true,
            ])
            ->add('common', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.common',
                'required' => true,
                'trim'     => true,
            ])
            ->add('rare', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.rare',
                'required' => true,
                'trim'     => true,
            ])
            ->add('epic', IntegerType::class, [
                 'attr'         => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'min' => 0,
                 ],
                'label'    => 'form.setting.unitprice.epic',
                'required' => true,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => SettingUnitPrice::class,
            'translation_domain' => 'forms',
        ]);
    }
}
