<?php

namespace App\Form\Back;

use App\Able\Form\FormAble;
use App\Entity\RaceRegion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceRegionType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'maxlength' => 64,
                ],
                'label' => 'form.name',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceRegion::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
