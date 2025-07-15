<?php

namespace App\Form\Back;

use App\Able\Form\FormAble;
use App\Entity\RaceRegion;
use App\Entity\RaceTrack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceTrackType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameEnglish', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'maxlength' => 64
                ],
                'label' => 'form.nameEnglish',
                'required' => true,
                'trim' => true,
            ])
            ->add('nameFrench', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'maxlength' => 64
                ],
                'label' => 'form.nameFrench',
                'required' => true,
                'trim' => true,
            ])
            ->add('region', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => RaceRegion::class,
                'choice_label' => 'name',
//                'choice_label' => 'id',
                'label' => 'form.region',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceTrack::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
