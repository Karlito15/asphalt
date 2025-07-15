<?php

namespace App\Form\Back;

use App\Able\Form\FormAble;
use App\Entity\RaceTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceTimeType extends AbstractType
{
    use FormAble;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', IntegerType::class, [
                'label' => 'form.name',
                'required' => true,
                'trim' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RaceTime::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
        ]);
    }
}
