<?php

declare(strict_types=1);

namespace App\Persistence\Form\Front\Garage;

use App\Persistence\Entity\GarageStatMax;
use App\Toolbox\Trait\Form\DefaultType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GarageStatMaxType extends AbstractType
{
    use DefaultType;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('speed', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.speed',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('acceleration', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.acceleration',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('handling', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.handling',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
            ->add('nitro', NumberType::class, [
                'attr'       => self::attrClass(),
                'label'      => 'text.nitro',
                'label_attr' => self::labelClass(),
                'scale'      => 2,
                'required'   => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => GarageStatMax::class,
            'allow_extra_fields' => false,
            'translation_domain' => 'messages',
        ]);
    }

    /**
     * @return array
     */
    private static function attrClass(): array
    {
        return [
            'autocomplete' => 'off',
            'class'        => 'text-center fw-bolder form-control-plaintext form-control-sm',
        ];
    }
}
