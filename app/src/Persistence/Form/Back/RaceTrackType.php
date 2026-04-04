<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\RaceRegion;
use App\Persistence\Entity\RaceTrack;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceTrackType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameEnglish', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'maxlength' => 64
                ],
                'label' => 'text.nameEnglish',
                'required' => true,
                'trim' => true,
            ])
            ->add('nameFrench', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class' => null,
                    'maxlength' => 64
                ],
                'label' => 'text.name.french',
                'required' => true,
                'trim' => true,
            ])
            ->add('region', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => RaceRegion::class,
                'choice_label' => 'name',
                'label' => 'text.region',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceTrack::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
