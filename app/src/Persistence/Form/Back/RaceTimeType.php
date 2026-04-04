<?php

declare(strict_types=1);

namespace App\Persistence\Form\Back;

use App\Persistence\Entity\RaceTime;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceTimeType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', IntegerType::class, [
                'label' => 'text.name',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceTime::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }
}
