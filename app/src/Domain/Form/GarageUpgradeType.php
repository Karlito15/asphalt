<?php

declare(strict_types=1);

namespace App\Domain\Form;

use App\Domain\Entity\GarageUpgrade;
use App\Infrastructure\Abstract\Form\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageUpgradeType extends AbstractForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', RangeType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false, //'form.speed',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('acceleration', RangeType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false, //'form.acceleration',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('handling', RangeType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false, //'form.handling',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('nitro', RangeType::class, [
                'attr'       => self::attrClassPrivate(),
                'label'      => false, //'form.nitro',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('common', RangeType::class, [
                'attr'       => self::attrClassPrivate(36),
                'label'      => false, //'form.common',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('rare', RangeType::class, [
                'attr'       => self::attrClassPrivate(20),
                'label'      => false, //'form.rare',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('epic', RangeType::class, [
                'attr'       => self::attrClassPrivate(16),
                'label'      => false, //'form.epic',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageUpgrade::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'forms',//messages
        ]);
    }

    /** PRIVATE METHODS */

    /**
     * @param int $max
     * @return array
     */
    private static function attrClassPrivate(int $max = 13): array
    {
        return [
            'max'          => $max,
            'min'          => 0,
            'step'         => 1,
        ];
    }
}
