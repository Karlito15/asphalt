<?php

namespace App\Form\Front;

use App\Entity\InventoryApp;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryAppType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', NumberType::class, [
                'attr'      => [
                    'autocomplete' => 'off',
                    'autocapitalize' => 'none',
                    'class' => 'text-end fw-bolder form-control-lg form-control',
                    'maxlength' => 10,
                    'minlength' => 0,
                ],
                'label'     => false,
                'required'  => true,
                'row_attr'  => self::labelClass(),
                'trim'      => true,
            ])
            ->add('id', HiddenType::class)
            ->add('label', HiddenType::class)
            ->add('filter', HiddenType::class)
            ->add('position', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InventoryApp::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
