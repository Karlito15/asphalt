<?php

namespace App\Form\Races;

use App\Entity\RaceSeason;
use App\Able\FormAble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chapter', IntegerType::class, [
                'attr'     => [
                    'min'     => 1,
                    'max'     => 6,
                ],
                'label'    => 'form.race.season.chapter',
                'required' => true,
                'trim'     => true,
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'autocomplete' => 'off',
                    'class'        => null,
                    'maxlength'    => 64,
                ],
                'label'    => 'form.race.season.name',
                'required' => true,
                'trim'     => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class'         => RaceSeason::class,
            'translation_domain' => 'forms',
        ]);
    }
}
