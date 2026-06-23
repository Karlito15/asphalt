<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageGauntlet;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageGauntletType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('division', IntegerType::class, [
                'attr'          => [
                    'autocomplete' => 'off',
                    'class'        => self::attrClass(),
                    'max'          => 9,
                    'min'          => 0,
                    'placeholder'  => 'form.division',
                ],
                'label'         => 'form.division',
                'label_attr'    => self::labelClass(),
                'required'      => false,
                'trim'          => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageGauntlet::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',//messages
        ]);
    }
}
