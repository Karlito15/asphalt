<?php

namespace App\Form\Races;

use App\Entity\RaceMode;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'maxlength'    => 32,
                ],
                'label'    => 'form.race.mode.name',
                'required' => true,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => RaceMode::class,
            'translation_domain' => 'forms',
        ]);
    }
}
