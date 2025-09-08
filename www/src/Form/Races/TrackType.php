<?php

namespace App\Form\Races;

use App\Entity\RaceRegion;
use App\Entity\RaceTrack;
use App\Able\FormAble;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameEnglish',    TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'maxlength'    => 64
                ],
                'label'    => 'form.race.track.nameEnglish',
                'required' => true,
                'trim'     => true,
            ])
            ->add('nameFrench',     TextType::class, [
                'attr'     => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'maxlength'    => 64
                ],
                'label'    => 'form.race.track.nameFrench',
                'required' => true,
                'trim'     => true,
            ])
            ->add('region', EntityType::class, [
                'attr'         => [
                    'class' => 'form-control',
                ],
                'class'        => RaceRegion::class,
                'choice_label' => 'name',
                'label'        => 'form.race.track.region',
                'required'     => true,
                'trim'         => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => RaceTrack::class,
            'translation_domain' => 'forms',
        ]);
    }
}
