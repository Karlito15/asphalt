<?php

namespace App\Form;

use App\Able\FormAble;
use App\Entity\AppInventory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices'  => [
                    'Money'  => 'money',
                    'Common' => 'common',
                    'Rare'   => 'rare',
                    'Joker'  => 'joker',

                ],
                'label'    => 'form.inventory.category',
                'required' => true,
                'trim'     => true,
            ])
            ->add('label', TextType::class, [
                'label'    => 'form.inventory.label',
                'required' => true,
                'trim'     => true,
            ])
            ->add('value', NumberType::class, [
                'label'    => 'form.inventory.value',
                'required' => true,
                'trim'     => true,
            ])
            ->add('filter', TextType::class, [
                'label'    => 'form.inventory.filter',
                'required' => true,
                'trim'     => true,
            ])
            ->add('position', NumberType::class, [
                'label'    => 'form.inventory.position',
                'required' => true,
                'trim'     => true,
            ])
            ->add('active', CheckboxType::class, [
                'attr'       => [
                    'class' => 'form-check-input',
                ],
                'label'      => 'form.inventory.active',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'required'   => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => AppInventory::class,
            'translation_domain' => 'forms',
        ]);
    }
}
