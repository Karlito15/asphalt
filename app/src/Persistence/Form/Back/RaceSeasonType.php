<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\RaceSeason;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceSeasonType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chapter', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 6,
                ],
                'label' => 'form.chapter',
                'required' => true,
                'trim' => true,
            ])
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
            'data_class' => RaceSeason::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',
        ]);
    }
}
