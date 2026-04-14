<?php

declare(strict_types=1);

namespace App\Domain\Form\Back;

use App\Domain\Entity\InventoryApp;
use App\Domain\Service\Type\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryAppType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices' => [
                    'text.money'  => 'money',
                    'text.common' => 'common',
                    'text.rare'   => 'rare',
                    'text.joker'  => 'joker',
                ],
                'label' => 'text.category',
                'required' => true,
                'trim' => true,
            ])
            ->add('label', TextType::class, [
                'label' => 'text.label',
                'required' => true,
                'trim' => true,
            ])
            ->add('value', NumberType::class, [
                'label' => 'text.value',
                'required' => true,
                'trim' => true,
            ])
            ->add('filter', ChoiceType::class, [
                'choices' => [
                    '---' => '---',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'S' => 'S',
                ],
                'label' => 'text.filter',
                'required' => true,
                'trim' => true,
            ])
            ->add('position', NumberType::class, [
                'label' => 'text.position',
                'required' => true,
                'trim' => true,
            ])
            ->add('active', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'label' => 'text.active',
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InventoryApp::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
