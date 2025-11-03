<?php

declare(strict_types=1);

namespace App\Form\Front;

use App\Entity\GarageUpgrade;
use App\Trait\Form\FormTrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageUpgradeType extends AbstractType
{
    use FormTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.speed',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('acceleration', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.acceleration',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('handling', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.handling',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('nitro', IntegerType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'form.nitro',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('common', IntegerType::class, [
                'attr'       => self::attrClass(36),
                'label'      => 'form.common',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('rare', IntegerType::class, [
                'attr'       => self::attrClass(20),
                'label'      => 'form.rare',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
            ->add('epic', IntegerType::class, [
                'attr'       => self::attrClass(16),
                'label'      => 'form.epic',
                'label_attr' => self::labelClass(),
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GarageUpgrade::class,
            'allow_extra_fields' => true,
            'translation_domain' => 'forms',
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
            'class'        => 'text-center fw-bolder m-0 p-0 form-control-plaintext form-control-sm',
            'max'          => $max,
            'min'          => 0,
        ];
    }
}
