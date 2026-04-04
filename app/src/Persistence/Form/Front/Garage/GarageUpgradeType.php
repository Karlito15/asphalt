<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageUpgrade;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageUpgradeType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', RangeType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.speed',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('acceleration', RangeType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.acceleration',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('handling', RangeType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.handling',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('nitro', RangeType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.nitro',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('common', RangeType::class, [
                'attr'       => self::attrClass(36),
                'label'      => 'text.common',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('rare', RangeType::class, [
                'attr'       => self::attrClass(20),
                'label'      => 'text.rare',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('epic', RangeType::class, [
                'attr'       => self::attrClass(16),
                'label'      => 'text.epic',
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
            'translation_domain' => 'messages',
        ]);
    }

    /**
     * @param int $max
     * @return array
     */
    private static function attrClass(int $max = 13): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => '',
            'max'          => $max,
            'min'          => 0,
            'step'         => 1,
        ];
    }
}
